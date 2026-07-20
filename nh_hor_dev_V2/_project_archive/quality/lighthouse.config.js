module.exports = {
  ci: {
    collect: {
      url: ['http://127.0.0.1:8080/'],
      numberOfRuns: 3,
      settings: { chromeFlags: '--headless --no-sandbox --disable-gpu', preset: 'desktop' }
    },
    assert: {
      assertions: {
        'categories:performance': ['warn', {minScore: 0.9}],
        'largest-contentful-paint': ['warn', {maxNumericValue: 2500}],
        'cumulative-layout-shift': ['warn', {maxNumericValue: 0.1}],
        'total-blocking-time': ['warn', {maxNumericValue: 200}]
      }
    },
    upload: { target: 'filesystem', outputDir: './lighthouse-results' }
  }
};
