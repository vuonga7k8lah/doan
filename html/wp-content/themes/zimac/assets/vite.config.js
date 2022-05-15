const { resolve } = require("path");
export default {
  build: {
    // generate manifest.json in outDir
    manifest: true,
    rollupOptions: {
      // overwrite default .html entry
      // input: "./main.js",
      input: {
        main: resolve(__dirname, "./main.js"),
        editor: resolve(__dirname, "./editor/index.js"),
      },
    },
  },
};
