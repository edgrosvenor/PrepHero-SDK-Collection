var JSON3 = require("../lib/json3.js");
console.log(JSON3.parse("[1, 2, 3]"));
console.log(JSON.stringify({"Hello": 123, "Good-bye": 456}, ["Hello"], "\t"));
var res = JSON.parse("[[1, 2, 3], 1, 2, 3, 4]", function (key, value) {
    if (typeof value == "number") {
      value = value % 2 ? "Odd" : "Even";
    }
    return value;
  });

console.log(res);