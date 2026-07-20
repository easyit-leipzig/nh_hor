#!/usr/bin/env python3
"""Prüft gerenderte HTML-Seiten auf grundlegende Dokument- und Überschriftenfehler."""
from __future__ import annotations
import argparse
import sys
from html.parser import HTMLParser
from urllib.request import Request, urlopen

class AuditParser(HTMLParser):
    def __init__(self) -> None:
        super().__init__(convert_charrefs=True)
        self.h1 = 0
        self.headings: list[int] = []
        self.ids: set[str] = set()
        self.duplicate_ids: set[str] = set()
        self.has_main = False
        self.lang = ""
        self.title_depth = 0
        self.title_text = ""

    def handle_starttag(self, tag: str, attrs):
        values = dict(attrs)
        if tag == "html": self.lang = values.get("lang", "").strip()
        if tag == "main": self.has_main = True
        if tag == "title": self.title_depth += 1
        if len(tag) == 2 and tag[0] == "h" and tag[1].isdigit():
            level = int(tag[1]); self.headings.append(level)
            if level == 1: self.h1 += 1
        element_id = values.get("id")
        if element_id:
            if element_id in self.ids: self.duplicate_ids.add(element_id)
            self.ids.add(element_id)

    def handle_endtag(self, tag: str):
        if tag == "title" and self.title_depth: self.title_depth -= 1

    def handle_data(self, data: str):
        if self.title_depth: self.title_text += data

def audit(url: str) -> list[str]:
    req = Request(url, headers={"User-Agent": "easyIT-quality-audit/1.0"})
    with urlopen(req, timeout=15) as response:
        html = response.read().decode(response.headers.get_content_charset() or "utf-8", "replace")
    parser = AuditParser(); parser.feed(html)
    errors: list[str] = []
    if parser.h1 != 1: errors.append(f"erwartet genau ein h1, gefunden: {parser.h1}")
    if not parser.has_main: errors.append("main-Element fehlt")
    if not parser.lang: errors.append("lang-Attribut am html-Element fehlt")
    if not parser.title_text.strip(): errors.append("title-Element ist leer oder fehlt")
    for previous, current in zip(parser.headings, parser.headings[1:]):
        if current > previous + 1:
            errors.append(f"Überschriftenebene springt von h{previous} auf h{current}")
    if parser.duplicate_ids: errors.append("doppelte IDs: " + ", ".join(sorted(parser.duplicate_ids)))
    return errors

def main() -> int:
    ap = argparse.ArgumentParser()
    ap.add_argument("urls", nargs="+", help="vollständige URLs der zu prüfenden Seiten")
    args = ap.parse_args()
    failed = False
    for url in args.urls:
        try: errors = audit(url)
        except Exception as exc:
            print(f"FAIL {url}: Abruf fehlgeschlagen: {exc}"); failed = True; continue
        if errors:
            print(f"FAIL {url}: " + "; ".join(errors)); failed = True
        else: print(f"OK   {url}")
    return 1 if failed else 0

if __name__ == "__main__":
    sys.exit(main())
