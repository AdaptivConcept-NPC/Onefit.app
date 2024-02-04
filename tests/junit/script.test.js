const basicJunitTestFunction = require("../../scripts/js/script.js");
// import { function1, function2 } from './script';
// import { basicJunitTestFunction } from '../../scripts/js/script.js';

// mock objects
// https://jestjs.io/docs/en/manual-mocks
// HLS is a global object for video player plugin, so we can mock it like this
global.Hls = {
  isSupported: jest.fn(),
  Events: {
    MANIFEST_PARSED: "manifestParsed",
  },
};

test("adds 1 + 2 to equal 3", () => {
  expect(basicJunitTestFunction(1, 2)).toBe(3);
});
