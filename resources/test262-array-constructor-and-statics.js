// Consolidated Test262 Array Tests (non-prototype, non-async)
// Source: https://github.com/tc39/test262/tree/main/test/built-ins/Array
// Excluded: prototype/*, fromAsync/*

// ===== test/built-ins/Array/15.4.5.1-5-1.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
es5id: 15.4.5.1-5-1
description: >
    Defining a property named 4294967295 (2**32-1)(not an array
    element)
---*/

var a = [];
a[4294967295] = "not an array element";

assert.sameValue(a[4294967295], "not an array element", 'The value of a[4294967295] is expected to be "not an array element"');

// ===== test/built-ins/Array/15.4.5.1-5-2.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
es5id: 15.4.5.1-5-2
description: >
    Defining a property named 4294967295 (2**32-1) doesn't change
    length of the array
---*/

var a = [0, 1, 2];
a[4294967295] = "not an array element";

assert.sameValue(a.length, 3, 'The value of a.length is expected to be 3');

// ===== test/built-ins/Array/15.4.5-1.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
es5id: 15.4.5-1
description: Array instances have [[Class]] set to 'Array'
---*/

var a = [];
var s = Object.prototype.toString.call(a);

assert.sameValue(s, '[object Array]', 'The value of s is expected to be "[object Array]"');

// ===== test/built-ins/Array/constructor.js =====
// Copyright (C) 2017 Leo Balter. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-constructor-array
description: >
  The Array constructor is a built-in function
---*/

assert.sameValue(typeof Array, 'function', 'The value of `typeof Array` is expected to be "function"');

// ===== test/built-ins/Array/from/Array.from_arity.js =====
// Copyright (c) 2014 the V8 project authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.
/*---
esid: sec-array.from
description: >
  The length property of the Array.from method is 1.
info: |
  22.1.2.1 Array.from ( items [ , mapfn [ , thisArg ] ] )

  ...

  The length property of the from method is 1.
includes: [propertyHelper.js]
---*/

verifyProperty(Array.from, "length", {
  value: 1,
  writable: false,
  enumerable: false,
  configurable: true
});

// ===== test/built-ins/Array/from/Array.from-descriptor.js =====
// Copyright 2015 Microsoft Corporation. All rights reserved.
// This code is governed by the license found in the LICENSE file.

/*---
description: Testing descriptor property of Array.from
includes: [propertyHelper.js]
esid: sec-array.from
---*/

verifyProperty(Array, "from", {
  writable: true,
  enumerable: false,
  configurable: true
});

// ===== test/built-ins/Array/from/Array.from_forwards-length-for-array-likes.js =====
// Copyright (c) 2014 the V8 project authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.
/*---
esid: sec-array.from
description: >
  If this is a constructor, and items doesn't have an @@iterator,
  returns a new instance of this
info: |
  22.1.2.1 Array.from ( items [ , mapfn [ , thisArg ] ] )

  4. Let usingIterator be GetMethod(items, @@iterator).
  ...
  6. If usingIterator is not undefined, then
  ...
  12. If IsConstructor(C) is true, then
    a. Let A be Construct(C, «len»).
  13. Else,
    a. Let A be ArrayCreate(len).
  ...
  19. Return A.
---*/

var result;

function MyCollection() {
  this.args = arguments;
}

result = Array.from.call(MyCollection, {
  length: 42
});

assert.sameValue(result.args.length, 1, 'The value of result.args.length is expected to be 1');
assert.sameValue(result.args[0], 42, 'The value of result.args[0] is expected to be 42');
assert(
  result instanceof MyCollection,
  'The result of evaluating (result instanceof MyCollection) is expected to be true'
);

// ===== test/built-ins/Array/from/Array.from-name.js =====
// Copyright 2015 Microsoft Corporation. All rights reserved.
// This code is governed by the license found in the LICENSE file.
/*---
esid: sec-array.from
description: '`name` property'
info: |
    ES6 Section 17:

    Every built-in Function object, including constructors, that is not
    identified as an anonymous function has a name property whose value is a
    String. Unless otherwise specified, this value is the name that is given to
    the function in this specification.

    [...]

    Unless otherwise specified, the name property of a built-in Function
    object, if it exists, has the attributes { [[Writable]]: false,
    [[Enumerable]]: false, [[Configurable]]: true }.
includes: [propertyHelper.js]
---*/

verifyProperty(Array.from, "name", {
  value: "from",
  writable: false,
  enumerable: false,
  configurable: true
});

// ===== test/built-ins/Array/from/array-like-has-length-but-no-indexes-with-values.js =====
// Copyright (c) 2021 Rick Waldron.  All rights reserved.
// This code is governed by the license found in the LICENSE file.

/*---
esid: sec-array.from
description: >
    Creates an array with length that is equal to the value of the
    length property of the given array-like, regardless of
    the presence of corresponding indices and values.
info: |
    Array.from ( items [ , mapfn [ , thisArg ] ] )

    7. Let arrayLike be ! ToObject(items).
    8. Let len be ? LengthOfArrayLike(arrayLike).
    9. If IsConstructor(C) is true, then
      a. Let A be ? Construct(C, « 𝔽(len) »).
    10. Else,
      a. Let A be ? ArrayCreate(len).

includes: [compareArray.js]
---*/

const length = 5;

const newlyCreatedArray = Array.from({ length });
assert.sameValue(
  newlyCreatedArray.length,
  length,
  "The newly created array's length is equal to the value of the length property for the provided array like object"
);
assert.compareArray(newlyCreatedArray, [undefined, undefined, undefined, undefined, undefined]);

const newlyCreatedAndMappedArray = Array.from({ length }).map(x => 1);
assert.sameValue(
  newlyCreatedAndMappedArray.length,
  length,
  "The newly created and mapped array's length is equal to the value of the length property for the provided array like object"
);
assert.compareArray(newlyCreatedAndMappedArray, [1, 1, 1, 1, 1]);

// ===== test/built-ins/Array/from/calling-from-valid-1-noStrict.js =====
// Copyright 2015 Microsoft Corporation. All rights reserved.
// This code is governed by the license found in the LICENSE file.
/*---
esid: sec-array.from
description: Map function without thisArg on non strict mode
info: |
  22.1.2.1 Array.from ( items [ , mapfn [ , thisArg ] ] )

  ...
  10. Let len be ToLength(Get(arrayLike, "length")).
  11. ReturnIfAbrupt(len).
  12. If IsConstructor(C) is true, then
    a. Let A be Construct(C, «len»).
  13. Else,
    b. Let A be ArrayCreate(len).
  14. ReturnIfAbrupt(A).
  15. Let k be 0.
  16. Repeat, while k < len
    a. Let Pk be ToString(k).
    b. Let kValue be Get(arrayLike, Pk).
    c. ReturnIfAbrupt(kValue).
    d. If mapping is true, then
      i. Let mappedValue be Call(mapfn, T, «kValue, k»).
  ...
flags: [noStrict]
---*/

var list = {
  '0': 41,
  '1': 42,
  '2': 43,
  length: 3
};
var calls = [];

function mapFn(value) {
  calls.push({
    args: arguments,
    thisArg: this
  });
  return value * 2;
}

var result = Array.from(list, mapFn);

assert.sameValue(result.length, 3, 'The value of result.length is expected to be 3');
assert.sameValue(result[0], 82, 'The value of result[0] is expected to be 82');
assert.sameValue(result[1], 84, 'The value of result[1] is expected to be 84');
assert.sameValue(result[2], 86, 'The value of result[2] is expected to be 86');

assert.sameValue(calls.length, 3, 'The value of calls.length is expected to be 3');

assert.sameValue(calls[0].args.length, 2, 'The value of calls[0].args.length is expected to be 2');
assert.sameValue(calls[0].args[0], 41, 'The value of calls[0].args[0] is expected to be 41');
assert.sameValue(calls[0].args[1], 0, 'The value of calls[0].args[1] is expected to be 0');
assert.sameValue(calls[0].thisArg, this, 'The value of calls[0].thisArg is expected to be this');

assert.sameValue(calls[1].args.length, 2, 'The value of calls[1].args.length is expected to be 2');
assert.sameValue(calls[1].args[0], 42, 'The value of calls[1].args[0] is expected to be 42');
assert.sameValue(calls[1].args[1], 1, 'The value of calls[1].args[1] is expected to be 1');
assert.sameValue(calls[1].thisArg, this, 'The value of calls[1].thisArg is expected to be this');

assert.sameValue(calls[2].args.length, 2, 'The value of calls[2].args.length is expected to be 2');
assert.sameValue(calls[2].args[0], 43, 'The value of calls[2].args[0] is expected to be 43');
assert.sameValue(calls[2].args[1], 2, 'The value of calls[2].args[1] is expected to be 2');
assert.sameValue(calls[2].thisArg, this, 'The value of calls[2].thisArg is expected to be this');

// ===== test/built-ins/Array/from/calling-from-valid-1-onlyStrict.js =====
// Copyright 2015 Microsoft Corporation. All rights reserved.
// This code is governed by the license found in the LICENSE file.
/*---
esid: sec-array.from
description: Map function without thisArg on strict mode
info: |
  22.1.2.1 Array.from ( items [ , mapfn [ , thisArg ] ] )

  ...
  10. Let len be ToLength(Get(arrayLike, "length")).
  11. ReturnIfAbrupt(len).
  12. If IsConstructor(C) is true, then
    a. Let A be Construct(C, «len»).
  13. Else,
    b. Let A be ArrayCreate(len).
  14. ReturnIfAbrupt(A).
  15. Let k be 0.
  16. Repeat, while k < len
    a. Let Pk be ToString(k).
    b. Let kValue be Get(arrayLike, Pk).
    c. ReturnIfAbrupt(kValue).
    d. If mapping is true, then
      i. Let mappedValue be Call(mapfn, T, «kValue, k»).
  ...
flags: [onlyStrict]
---*/

var list = {
  '0': 41,
  '1': 42,
  '2': 43,
  length: 3
};
var calls = [];

function mapFn(value) {
  calls.push({
    args: arguments,
    thisArg: this
  });
  return value * 2;
}

var result = Array.from(list, mapFn);

assert.sameValue(result.length, 3, 'The value of result.length is expected to be 3');
assert.sameValue(result[0], 82, 'The value of result[0] is expected to be 82');
assert.sameValue(result[1], 84, 'The value of result[1] is expected to be 84');
assert.sameValue(result[2], 86, 'The value of result[2] is expected to be 86');

assert.sameValue(calls.length, 3, 'The value of calls.length is expected to be 3');

assert.sameValue(calls[0].args.length, 2, 'The value of calls[0].args.length is expected to be 2');
assert.sameValue(calls[0].args[0], 41, 'The value of calls[0].args[0] is expected to be 41');
assert.sameValue(calls[0].args[1], 0, 'The value of calls[0].args[1] is expected to be 0');
assert.sameValue(calls[0].thisArg, undefined, 'The value of calls[0].thisArg is expected to equal undefined');

assert.sameValue(calls[1].args.length, 2, 'The value of calls[1].args.length is expected to be 2');
assert.sameValue(calls[1].args[0], 42, 'The value of calls[1].args[0] is expected to be 42');
assert.sameValue(calls[1].args[1], 1, 'The value of calls[1].args[1] is expected to be 1');
assert.sameValue(calls[1].thisArg, undefined, 'The value of calls[1].thisArg is expected to equal undefined');

assert.sameValue(calls[2].args.length, 2, 'The value of calls[2].args.length is expected to be 2');
assert.sameValue(calls[2].args[0], 43, 'The value of calls[2].args[0] is expected to be 43');
assert.sameValue(calls[2].args[1], 2, 'The value of calls[2].args[1] is expected to be 2');
assert.sameValue(calls[2].thisArg, undefined, 'The value of calls[2].thisArg is expected to equal undefined');

// ===== test/built-ins/Array/from/calling-from-valid-2.js =====
// Copyright 2015 Microsoft Corporation. All rights reserved.
// This code is governed by the license found in the LICENSE file.

/*---
esid: sec-array.from
description: Calling from with a valid map function with thisArg
info: |
  22.1.2.1 Array.from ( items [ , mapfn [ , thisArg ] ] )

  ...
  10. Let len be ToLength(Get(arrayLike, "length")).
  11. ReturnIfAbrupt(len).
  12. If IsConstructor(C) is true, then
    a. Let A be Construct(C, «len»).
  13. Else,
    b. Let A be ArrayCreate(len).
  14. ReturnIfAbrupt(A).
  15. Let k be 0.
  16. Repeat, while k < len
    a. Let Pk be ToString(k).
    b. Let kValue be Get(arrayLike, Pk).
    c. ReturnIfAbrupt(kValue).
    d. If mapping is true, then
      i. Let mappedValue be Call(mapfn, T, «kValue, k»).
  ...
---*/

var list = {
  '0': 41,
  '1': 42,
  '2': 43,
  length: 3
};
var calls = [];
var thisArg = {};

function mapFn(value) {
  calls.push({
    args: arguments,
    thisArg: this
  });
  return value * 2;
}

var result = Array.from(list, mapFn, thisArg);

assert.sameValue(result.length, 3, 'The value of result.length is expected to be 3');
assert.sameValue(result[0], 82, 'The value of result[0] is expected to be 82');
assert.sameValue(result[1], 84, 'The value of result[1] is expected to be 84');
assert.sameValue(result[2], 86, 'The value of result[2] is expected to be 86');

assert.sameValue(calls.length, 3, 'The value of calls.length is expected to be 3');

assert.sameValue(calls[0].args.length, 2, 'The value of calls[0].args.length is expected to be 2');
assert.sameValue(calls[0].args[0], 41, 'The value of calls[0].args[0] is expected to be 41');
assert.sameValue(calls[0].args[1], 0, 'The value of calls[0].args[1] is expected to be 0');
assert.sameValue(calls[0].thisArg, thisArg, 'The value of calls[0].thisArg is expected to equal the value of thisArg');

assert.sameValue(calls[1].args.length, 2, 'The value of calls[1].args.length is expected to be 2');
assert.sameValue(calls[1].args[0], 42, 'The value of calls[1].args[0] is expected to be 42');
assert.sameValue(calls[1].args[1], 1, 'The value of calls[1].args[1] is expected to be 1');
assert.sameValue(calls[1].thisArg, thisArg, 'The value of calls[1].thisArg is expected to equal the value of thisArg');

assert.sameValue(calls[2].args.length, 2, 'The value of calls[2].args.length is expected to be 2');
assert.sameValue(calls[2].args[0], 43, 'The value of calls[2].args[0] is expected to be 43');
assert.sameValue(calls[2].args[1], 2, 'The value of calls[2].args[1] is expected to be 2');
assert.sameValue(calls[2].thisArg, thisArg, 'The value of calls[2].thisArg is expected to equal the value of thisArg');

// ===== test/built-ins/Array/from/elements-added-after.js =====
// Copyright 2015 Microsoft Corporation. All rights reserved.
// This code is governed by the license found in the LICENSE file.

/*---
description: Elements added after the call to from
esid: sec-array.from
---*/

var arrayIndex = -1;
var originalLength = 7;
var obj = {
  length: originalLength,
  0: 2,
  1: 4,
  2: 8,
  3: 16,
  4: 32,
  5: 64,
  6: 128
};
var array = [2, 4, 8, 16, 32, 64, 128];

function mapFn(value, index) {
  arrayIndex++;
  assert.sameValue(value, obj[arrayIndex], 'The value of value is expected to equal the value of obj[arrayIndex]');
  assert.sameValue(index, arrayIndex, 'The value of index is expected to equal the value of arrayIndex');
  obj[originalLength + arrayIndex] = 2 * arrayIndex + 1;

  return obj[arrayIndex];
}


var a = Array.from(obj, mapFn);
assert.sameValue(a.length, array.length, 'The value of a.length is expected to equal the value of array.length');

for (var j = 0; j < a.length; j++) {
  assert.sameValue(a[j], array[j], 'The value of a[j] is expected to equal the value of array[j]');
}

// ===== test/built-ins/Array/from/elements-deleted-after.js =====
// Copyright 2015 Microsoft Corporation. All rights reserved.
// This code is governed by the license found in the LICENSE file.

/*---
description: >
    Elements deleted after the call started and before visited are not
    visited
esid: sec-array.from
---*/

var originalArray = [0, 1, -2, 4, -8, 16];
var array = [0, 1, -2, 4, -8, 16];
var a = [];
var arrayIndex = -1;

function mapFn(value, index) {
  this.arrayIndex++;
  assert.sameValue(value, array[this.arrayIndex], 'The value of value is expected to equal the value of array[this.arrayIndex]');
  assert.sameValue(index, this.arrayIndex, 'The value of index is expected to equal the value of this.arrayIndex');

  array.splice(array.length - 1, 1);
  return 127;
}


a = Array.from(array, mapFn, this);

assert.sameValue(a.length, originalArray.length / 2, 'The value of a.length is expected to be originalArray.length / 2');

for (var j = 0; j < originalArray.length / 2; j++) {
  assert.sameValue(a[j], 127, 'The value of a[j] is expected to be 127');
}

// ===== test/built-ins/Array/from/elements-updated-after.js =====
// Copyright 2015 Microsoft Corporation. All rights reserved.
// This code is governed by the license found in the LICENSE file.

/*---
description: Elements are updated after the call to from
esid: sec-array.from
---*/

var array = [127, 4, 8, 16, 32, 64, 128];
var arrayIndex = -1;

function mapFn(value, index) {
  arrayIndex++;
  if (index + 1 < array.length) {
    array[index + 1] = 127;
  }
  assert.sameValue(value, 127, 'The value of value is expected to be 127');
  assert.sameValue(index, arrayIndex, 'The value of index is expected to equal the value of arrayIndex');

  return value;
}

var a = Array.from(array, mapFn);
assert.sameValue(a.length, array.length, 'The value of a.length is expected to equal the value of array.length');
for (var j = 0; j < a.length; j++) {
  assert.sameValue(a[j], 127, 'The value of a[j] is expected to be 127');
}

// ===== test/built-ins/Array/from/from-array.js =====
// Copyright 2015 Microsoft Corporation. All rights reserved.
// This code is governed by the license found in the LICENSE file.

/*---
description: Passing a valid array
esid: sec-array.from
---*/

var array = [0, 'foo', , Infinity];
var result = Array.from(array);

assert.sameValue(result.length, 4, 'The value of result.length is expected to be 4');
assert.sameValue(result[0], 0, 'The value of result[0] is expected to be 0');
assert.sameValue(result[1], 'foo', 'The value of result[1] is expected to be "foo"');
assert.sameValue(result[2], undefined, 'The value of result[2] is expected to equal undefined');
assert.sameValue(result[3], Infinity, 'The value of result[3] is expected to equal Infinity');

assert.notSameValue(
  result, array,
  'The value of result is expected to not equal the value of `array`'
);

assert(result instanceof Array, 'The result of evaluating (result instanceof Array) is expected to be true');

// ===== test/built-ins/Array/from/from-string.js =====
// Copyright (c) 2014 Hank Yates. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.from
description: Testing Array.from when passed a String
author: Hank Yates (hankyates@gmail.com)
---*/

var arrLikeSource = 'Test';
var result = Array.from(arrLikeSource);

assert.sameValue(result.length, 4, 'The value of result.length is expected to be 4');
assert.sameValue(result[0], 'T', 'The value of result[0] is expected to be "T"');
assert.sameValue(result[1], 'e', 'The value of result[1] is expected to be "e"');
assert.sameValue(result[2], 's', 'The value of result[2] is expected to be "s"');
assert.sameValue(result[3], 't', 'The value of result[3] is expected to be "t"');

// ===== test/built-ins/Array/from/get-iter-method-err.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.from
description: Error accessing items' `Symbol.iterator` attribute
info: |
    [...]
    4. Let usingIterator be GetMethod(items, @@iterator).
    5. ReturnIfAbrupt(usingIterator).
features: [Symbol.iterator]
---*/

var items = {};
Object.defineProperty(items, Symbol.iterator, {
  get: function() {
    throw new Test262Error();
  }
});

assert.throws(Test262Error, function() {
  Array.from(items);
}, 'Array.from(items) throws a Test262Error exception');

// ===== test/built-ins/Array/from/items-is-arraybuffer.js =====
// Copyright 2015 Leonardo Balter. All rights reserved.
// This code is governed by the license found in the LICENSE file.
/*---
esid: sec-array.from
description: Return empty array if items argument is an ArrayBuffer
info: |
  22.1.2.1 Array.from ( items [ , mapfn [ , thisArg ] ] )

  ...
  4. Let usingIterator be GetMethod(items, @@iterator).
  5. ReturnIfAbrupt(usingIterator).
  ...
---*/

var arrayBuffer = new ArrayBuffer(7);

var result = Array.from(arrayBuffer);

assert.sameValue(result.length, 0, 'The value of result.length is expected to be 0');

// ===== test/built-ins/Array/from/items-is-null-throws.js =====
// Copyright 2015 Leonardo Balter. All rights reserved.
// This code is governed by the license found in the LICENSE file.
/*---
esid: sec-array.from
description: Throws a TypeError if items argument is null
info: |
  22.1.2.1 Array.from ( items [ , mapfn [ , thisArg ] ] )

  ...
  4. Let usingIterator be GetMethod(items, @@iterator).
  5. ReturnIfAbrupt(usingIterator).
  ...
---*/

assert.throws(TypeError, function() {
  Array.from(null);
}, 'Array.from(null) throws a TypeError exception');

// ===== test/built-ins/Array/from/iter-adv-err.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.from
description: Error advancing iterator
info: |
    [...]
    6. If usingIterator is not undefined, then
       [...]
       g. Repeat
          i. Let Pk be ToString(k).
          ii. Let next be IteratorStep(iterator).
          iii. ReturnIfAbrupt(next).
features: [Symbol.iterator]
---*/

var items = {};
items[Symbol.iterator] = function() {
  return {
    next: function() {
      throw new Test262Error();
    }
  };
};

assert.throws(Test262Error, function() {
  Array.from(items);
}, 'Array.from(items) throws a Test262Error exception');

// ===== test/built-ins/Array/from/iter-cstm-ctor-err.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.from
description: >
    Error creating object with custom constructor (traversed via iterator)
info: |
    [...]
    6. If usingIterator is not undefined, then
       a. If IsConstructor(C) is true, then
          i. Let A be Construct(C).
       b. Else,
          i. Let A be ArrayCreate(0).
       c. ReturnIfAbrupt(A).
features: [Symbol.iterator]
---*/

var C = function() {
  throw new Test262Error();
};
var items = {};
items[Symbol.iterator] = function() {};

assert.throws(Test262Error, function() {
  Array.from.call(C, items);
}, 'Array.from.call(C, items) throws a Test262Error exception');

// ===== test/built-ins/Array/from/iter-cstm-ctor.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.from
description: Creating object with custom constructor (traversed via iterator)
info: |
    [...]
    6. If usingIterator is not undefined, then
       a. If IsConstructor(C) is true, then
          i. Let A be Construct(C).
       b. Else,
          i. Let A be ArrayCreate(0).
       c. ReturnIfAbrupt(A).
features: [Symbol.iterator]
---*/

var thisVal, args;
var callCount = 0;
var C = function() {
  thisVal = this;
  args = arguments;
  callCount += 1;
};
var result;
var items = {};
items[Symbol.iterator] = function() {
  return {
    next: function() {
      return {
        done: true
      };
    }
  };
};

result = Array.from.call(C, items);

assert(
  result instanceof C, 'The result of evaluating (result instanceof C) is expected to be true'
);
assert.sameValue(
  result.constructor,
  C,
  'The value of result.constructor is expected to equal the value of C'
);
assert.sameValue(callCount, 1, 'The value of callCount is expected to be 1');
assert.sameValue(thisVal, result, 'The value of thisVal is expected to equal the value of result');
assert.sameValue(args.length, 0, 'The value of args.length is expected to be 0');

// ===== test/built-ins/Array/from/iter-get-iter-err.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.from
description: Error creating iterator object
info: |
    [...]
    6. If usingIterator is not undefined, then
       [...]
       d. Let iterator be GetIterator(items, usingIterator).
       e. ReturnIfAbrupt(iterator).
features: [Symbol.iterator]
---*/

var itemsPoisonedSymbolIterator = {};
itemsPoisonedSymbolIterator[Symbol.iterator] = function() {
  throw new Test262Error();
};

assert.throws(Test262Error, function() {
  Array.from(itemsPoisonedSymbolIterator);
}, 'Array.from(itemsPoisonedSymbolIterator) throws a Test262Error exception');

// ===== test/built-ins/Array/from/iter-get-iter-val-err.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.from
description: Error retrieving value of iterator result
info: |
    [...]
    6. If usingIterator is not undefined, then
       [...]
       g. Repeat
          [...]
          v. Let nextValue be IteratorValue(next).
          vi. ReturnIfAbrupt(nextValue).
features: [Symbol.iterator]
---*/

var itemsPoisonedIteratorValue = {};
var poisonedValue = {};
Object.defineProperty(poisonedValue, 'value', {
  get: function() {
    throw new Test262Error();
  }
});
itemsPoisonedIteratorValue[Symbol.iterator] = function() {
  return {
    next: function() {
      return poisonedValue;
    }
  };
};

assert.throws(Test262Error, function() {
  Array.from(itemsPoisonedIteratorValue);
}, 'Array.from(itemsPoisonedIteratorValue) throws a Test262Error exception');

// ===== test/built-ins/Array/from/iter-map-fn-args.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.from
description: >
    Arguments of mapping function (traversed via iterator)
info: |
    [...]
    2. If mapfn is undefined, let mapping be false.
    3. else
       a. If IsCallable(mapfn) is false, throw a TypeError exception.
       b. If thisArg was supplied, let T be thisArg; else let T be undefined.
       c. Let mapping be true
    [...]
    6. If usingIterator is not undefined, then
       [...]
       g. Repeat
          [...]
          vii. If mapping is true, then
               1. Let mappedValue be Call(mapfn, T, «nextValue, k»).
               2. If mappedValue is an abrupt completion, return
                  IteratorClose(iterator, mappedValue).
               3. Let mappedValue be mappedValue.[[value]].
features: [Symbol.iterator]
---*/

var args = [];
var firstResult = {
  done: false,
  value: {}
};
var secondResult = {
  done: false,
  value: {}
};
var mapFn = function(value, idx) {
  args.push(arguments);
};
var items = {};
var nextResult = firstResult;
var nextNextResult = secondResult;

items[Symbol.iterator] = function() {
  return {
    next: function() {
      var result = nextResult;
      nextResult = nextNextResult;
      nextNextResult = {
        done: true
      };

      return result;
    }
  };
};

Array.from(items, mapFn);

assert.sameValue(args.length, 2, 'The value of args.length is expected to be 2');

assert.sameValue(args[0].length, 2, 'The value of args[0].length is expected to be 2');
assert.sameValue(
  args[0][0], firstResult.value, 'The value of args[0][0] is expected to equal the value of firstResult.value'
);
assert.sameValue(args[0][1], 0, 'The value of args[0][1] is expected to be 0');

assert.sameValue(args[1].length, 2, 'The value of args[1].length is expected to be 2');
assert.sameValue(
  args[1][0], secondResult.value, 'The value of args[1][0] is expected to equal the value of secondResult.value'
);
assert.sameValue(args[1][1], 1, 'The value of args[1][1] is expected to be 1');

// ===== test/built-ins/Array/from/iter-map-fn-err.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.from
description: Error invoking map function (traversed via iterator)
info: |
    [...]
    6. If usingIterator is not undefined, then
       [...]
       g. Repeat
          [...]
          vii. If mapping is true, then
               1. Let mappedValue be Call(mapfn, T, «nextValue, k»).
               2. If mappedValue is an abrupt completion, return
                  IteratorClose(iterator, mappedValue).
features: [Symbol.iterator]
---*/

var closeCount = 0;
var mapFn = function() {
  throw new Test262Error();
};
var items = {};
items[Symbol.iterator] = function() {
  return {
    return: function() {
      closeCount += 1;
    },
    next: function() {
      return {
        done: false
      };
    }
  };
};

assert.throws(Test262Error, function() {
  Array.from(items, mapFn);
}, 'Array.from(items, mapFn) throws a Test262Error exception');

assert.sameValue(closeCount, 1, 'The value of closeCount is expected to be 1');

// ===== test/built-ins/Array/from/iter-map-fn-return.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.from
description: Value returned by mapping function (traversed via iterator)
info: |
    [...]
    2. If mapfn is undefined, let mapping be false.
    3. else
       a. If IsCallable(mapfn) is false, throw a TypeError exception.
       b. If thisArg was supplied, let T be thisArg; else let T be undefined.
       c. Let mapping be true
    [...]
    6. If usingIterator is not undefined, then
       [...]
       g. Repeat
          [...]
          vii. If mapping is true, then
               1. Let mappedValue be Call(mapfn, T, «nextValue, k»).
               2. If mappedValue is an abrupt completion, return
                  IteratorClose(iterator, mappedValue).
               3. Let mappedValue be mappedValue.[[value]].
features: [Symbol.iterator]
---*/

var thisVals = [];
var nextResult = {
  done: false,
  value: {}
};
var nextNextResult = {
  done: false,
  value: {}
};
var firstReturnVal = {};
var secondReturnVal = {};
var mapFn = function(value, idx) {
  var returnVal = nextReturnVal;
  nextReturnVal = nextNextReturnVal;
  nextNextReturnVal = null;
  return returnVal;
};
var nextReturnVal = firstReturnVal;
var nextNextReturnVal = secondReturnVal;
var items = {};
var result;

items[Symbol.iterator] = function() {
  return {
    next: function() {
      var result = nextResult;
      nextResult = nextNextResult;
      nextNextResult = {
        done: true
      };

      return result;
    }
  };
};

result = Array.from(items, mapFn);

assert.sameValue(result.length, 2, 'The value of result.length is expected to be 2');
assert.sameValue(result[0], firstReturnVal, 'The value of result[0] is expected to equal the value of firstReturnVal');
assert.sameValue(
  result[1],
  secondReturnVal,
  'The value of result[1] is expected to equal the value of secondReturnVal'
);

// ===== test/built-ins/Array/from/iter-map-fn-this-arg.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.from
description: >
    `this` value of mapping function with custom `this` argument (traversed via iterator)
info: |
    [...]
    2. If mapfn is undefined, let mapping be false.
    3. else
       a. If IsCallable(mapfn) is false, throw a TypeError exception.
       b. If thisArg was supplied, let T be thisArg; else let T be undefined.
       c. Let mapping be true
    [...]
    6. If usingIterator is not undefined, then
       [...]
       g. Repeat
          [...]
          vii. If mapping is true, then
               1. Let mappedValue be Call(mapfn, T, «nextValue, k»).
features: [Symbol.iterator]
---*/

var thisVals = [];
var nextResult = {
  done: false,
  value: {}
};
var nextNextResult = {
  done: false,
  value: {}
};
var mapFn = function() {
  thisVals.push(this);
};
var items = {};
var thisVal = {};

items[Symbol.iterator] = function() {
  return {
    next: function() {
      var result = nextResult;
      nextResult = nextNextResult;
      nextNextResult = {
        done: true
      };

      return result;
    }
  };
};

Array.from(items, mapFn, thisVal);

assert.sameValue(thisVals.length, 2, 'The value of thisVals.length is expected to be 2');
assert.sameValue(thisVals[0], thisVal, 'The value of thisVals[0] is expected to equal the value of thisVal');
assert.sameValue(thisVals[1], thisVal, 'The value of thisVals[1] is expected to equal the value of thisVal');

// ===== test/built-ins/Array/from/iter-map-fn-this-non-strict.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.from
description: >
    `this` value of mapping function in non-strict mode (traversed via iterator)
info: |
    [...]
    2. If mapfn is undefined, let mapping be false.
    3. else
       a. If IsCallable(mapfn) is false, throw a TypeError exception.
       b. If thisArg was supplied, let T be thisArg; else let T be undefined.
       c. Let mapping be true
    [...]
    6. If usingIterator is not undefined, then
       [...]
       g. Repeat
          [...]
          vii. If mapping is true, then
               1. Let mappedValue be Call(mapfn, T, «nextValue, k»).
features: [Symbol.iterator]
flags: [noStrict]
---*/

var thisVals = [];
var nextResult = {
  done: false,
  value: {}
};
var nextNextResult = {
  done: false,
  value: {}
};
var mapFn = function() {
  thisVals.push(this);
};
var items = {};
var global = function() {
  return this;
}();

items[Symbol.iterator] = function() {
  return {
    next: function() {
      var result = nextResult;
      nextResult = nextNextResult;
      nextNextResult = {
        done: true
      };

      return result;
    }
  };
};

Array.from(items, mapFn);

assert.sameValue(thisVals.length, 2, 'The value of thisVals.length is expected to be 2');
assert.sameValue(thisVals[0], global, 'The value of thisVals[0] is expected to equal the value of global');
assert.sameValue(thisVals[1], global, 'The value of thisVals[1] is expected to equal the value of global');

// ===== test/built-ins/Array/from/iter-map-fn-this-strict.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.from
description: >
    `this` value of mapping function in strict mode (traversed via iterator)
info: |
    [...]
    2. If mapfn is undefined, let mapping be false.
    3. else
       a. If IsCallable(mapfn) is false, throw a TypeError exception.
       b. If thisArg was supplied, let T be thisArg; else let T be undefined.
       c. Let mapping be true
    [...]
    6. If usingIterator is not undefined, then
       [...]
       g. Repeat
          [...]
          vii. If mapping is true, then
               1. Let mappedValue be Call(mapfn, T, «nextValue, k»).
features: [Symbol.iterator]
flags: [onlyStrict]
---*/

var thisVals = [];
var nextResult = {
  done: false,
  value: {}
};
var nextNextResult = {
  done: false,
  value: {}
};
var mapFn = function() {
  thisVals.push(this);
};
var items = {};

items[Symbol.iterator] = function() {
  return {
    next: function() {
      var result = nextResult;
      nextResult = nextNextResult;
      nextNextResult = {
        done: true
      };

      return result;
    }
  };
};

Array.from(items, mapFn);

assert.sameValue(thisVals.length, 2, 'The value of thisVals.length is expected to be 2');
assert.sameValue(thisVals[0], undefined, 'The value of thisVals[0] is expected to equal undefined');
assert.sameValue(thisVals[1], undefined, 'The value of thisVals[1] is expected to equal undefined');

// ===== test/built-ins/Array/from/iter-set-elem-prop-err.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.from
description: Error setting property on result value (traversed via iterator)
info: |
    [...]
    6. If usingIterator is not undefined, then
       [...]
       g. Repeat
          [...]
          ix. Let defineStatus be CreateDataPropertyOrThrow(A, Pk,
              mappedValue).
          x. If defineStatus is an abrupt completion, return
             IteratorClose(iterator, defineStatus).
features: [Symbol.iterator]
---*/

var constructorSetsIndex0ConfigurableFalse = function() {
  Object.defineProperty(this, '0', {
    writable: true,
    configurable: false
  });
};
var closeCount = 0;
var items = {};
var nextResult = {
  done: false
};

items[Symbol.iterator] = function() {
  return {
    return: function() {
      closeCount += 1;
    },
    next: function() {
      var result = nextResult;

      nextResult = {
        done: true
      };

      return result;
    }
  };
};

assert.throws(TypeError, function() {
  Array.from.call(constructorSetsIndex0ConfigurableFalse, items);
}, 'Array.from.call(constructorSetsIndex0ConfigurableFalse, items) throws a TypeError exception');

assert.sameValue(closeCount, 1, 'The value of closeCount is expected to be 1');

// ===== test/built-ins/Array/from/iter-set-elem-prop.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.from
description: Setting property on result value (traversed via iterator)
info: |
    [...]
    6. If usingIterator is not undefined, then
       [...]
       g. Repeat
          [...]
          ix. Let defineStatus be CreateDataPropertyOrThrow(A, Pk,
              mappedValue).
features: [Symbol.iterator]
---*/

var items = {};
var firstIterResult = {
  done: false,
  value: {}
};
var secondIterResult = {
  done: false,
  value: {}
};
var thirdIterResult = {
  done: true,
  value: {}
};
var nextIterResult = firstIterResult;
var nextNextIterResult = secondIterResult;
var result;

items[Symbol.iterator] = function() {
  return {
    next: function() {
      var result = nextIterResult;

      nextIterResult = nextNextIterResult;
      nextNextIterResult = thirdIterResult;

      return result;
    }
  };
};

result = Array.from(items);

assert.sameValue(
  result[0],
  firstIterResult.value,
  'The value of result[0] is expected to equal the value of firstIterResult.value'
);
assert.sameValue(
  result[1],
  secondIterResult.value,
  'The value of result[1] is expected to equal the value of secondIterResult.value'
);

// ===== test/built-ins/Array/from/iter-set-elem-prop-non-writable.js =====
// Copyright (C) 2020 Alexey Shvayka. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.from
description: >
  Non-writable properties are overwritten by CreateDataProperty.
  (result object's "0" is non-writable, items is iterable)
info: |
  Array.from ( items [ , mapfn [ , thisArg ] ] )

  [...]
  5. If usingIterator is not undefined, then
    [...]
    e. Repeat,
      [...]
      viii. Let defineStatus be CreateDataPropertyOrThrow(A, Pk, mappedValue).
    [...]
features: [generators]
includes: [propertyHelper.js]
---*/

var items = function* () {
  yield 2;
};

var A = function(_length) {
  Object.defineProperty(this, "0", {
    value: 1,
    writable: false,
    enumerable: false,
    configurable: true,
  });
};

var res = Array.from.call(A, items());

verifyProperty(res, "0", {
  value: 2,
  writable: true,
  enumerable: true,
  configurable: true,
});

// ===== test/built-ins/Array/from/iter-set-length-err.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.from
description: Error setting length of object (traversed via iterator)
info: |
    [...]
    6. If usingIterator is not undefined, then
       [...]
       g. Repeat
          [...]
          iv. If next is false, then
              1. Let setStatus be Set(A, "length", k, true).
              2. ReturnIfAbrupt(setStatus).
features: [Symbol.iterator]
---*/

var poisonedPrototypeLength = function() {};
var items = {};
Object.defineProperty(poisonedPrototypeLength.prototype, 'length', {
  set: function(_) {
    throw new Test262Error();
  }
});
items[Symbol.iterator] = function() {
  return {
    next: function() {
      return {
        done: true
      };
    }
  };
};

assert.throws(Test262Error, function() {
  Array.from.call(poisonedPrototypeLength, items);
}, 'Array.from.call(poisonedPrototypeLength, items) throws a Test262Error exception');

// ===== test/built-ins/Array/from/iter-set-length.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.from
description: Setting length of object (traversed via iterator)
info: |
    [...]
    6. If usingIterator is not undefined, then
       [...]
       g. Repeat
          [...]
          iv. If next is false, then
              1. Let setStatus be Set(A, "length", k, true).
              2. ReturnIfAbrupt(setStatus).
              3. Return A.
features: [Symbol.iterator]
---*/

var items = {};
var result, nextIterResult, lastIterResult;
items[Symbol.iterator] = function() {
  return {
    next: function() {
      var result = nextIterResult;
      nextIterResult = lastIterResult;
      return result;
    }
  };
};

nextIterResult = lastIterResult = {
  done: true
};
result = Array.from(items);

assert.sameValue(result.length, 0, 'The value of result.length is expected to be 0');

nextIterResult = {
  done: false
};
lastIterResult = {
  done: true
};
result = Array.from(items);

assert.sameValue(result.length, 1, 'The value of result.length is expected to be 1');

// ===== test/built-ins/Array/from/mapfn-is-not-callable-typeerror.js =====
// Copyright 2015 Leonardo Balter. All rights reserved.
// This code is governed by the license found in the LICENSE file.
/*---
esid: sec-array.from
description: Throws a TypeError if mapFn is not callable
info: |
  22.1.2.1 Array.from ( items [ , mapfn [ , thisArg ] ] )

  ...
  2. If mapfn is undefined, let mapping be false.
  3. else
    a. If IsCallable(mapfn) is false, throw a TypeError exception.
    ...
---*/

assert.throws(TypeError, function() {
  Array.from([], null);
}, 'Array.from([], null) throws a TypeError exception');

assert.throws(TypeError, function() {
  Array.from([], {});
}, 'Array.from([], {}) throws a TypeError exception');

assert.throws(TypeError, function() {
  Array.from([], 'string');
}, 'Array.from([], "string") throws a TypeError exception');

assert.throws(TypeError, function() {
  Array.from([], true);
}, 'Array.from([], true) throws a TypeError exception');

assert.throws(TypeError, function() {
  Array.from([], 42);
}, 'Array.from([], 42) throws a TypeError exception');

// ===== test/built-ins/Array/from/mapfn-is-symbol-throws.js =====
// Copyright 2015 Leonardo Balter. All rights reserved.
// This code is governed by the license found in the LICENSE file.
/*---
esid: sec-array.from
description: Throws a TypeError if mapFn is not callable (Symbol)
info: |
  22.1.2.1 Array.from ( items [ , mapfn [ , thisArg ] ] )

  ...
  2. If mapfn is undefined, let mapping be false.
  3. else
    a. If IsCallable(mapfn) is false, throw a TypeError exception.
    ...
features:
  - Symbol
---*/

assert.throws(TypeError, function() {
  Array.from([], Symbol('1'));
}, 'Array.from([], Symbol("1")) throws a TypeError exception');

// ===== test/built-ins/Array/from/mapfn-throws-exception.js =====
// Copyright 2015 Microsoft Corporation. All rights reserved.
// This code is governed by the license found in the LICENSE file.

/*---
description: mapFn throws an exception
esid: sec-array.from
es6id: 22.1.2.1
---*/

var array = [2, 4, 8, 16, 32, 64, 128];

function mapFnThrows(value, index, obj) {
  throw new Test262Error();
}

assert.throws(Test262Error, function() {
  Array.from(array, mapFnThrows);
}, 'Array.from(array, mapFnThrows) throws a Test262Error exception');

// ===== test/built-ins/Array/from/not-a-constructor.js =====
// Copyright (C) 2020 Rick Waldron. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-ecmascript-standard-built-in-objects
description: >
  Array.from does not implement [[Construct]], is not new-able
info: |
  ECMAScript Function Objects

  Built-in function objects that are not identified as constructors do not
  implement the [[Construct]] internal method unless otherwise specified in
  the description of a particular function.

  sec-evaluatenew

  ...
  7. If IsConstructor(constructor) is false, throw a TypeError exception.
  ...
includes: [isConstructor.js]
features: [Reflect.construct, arrow-function]
---*/

assert.sameValue(isConstructor(Array.from), false, 'isConstructor(Array.from) must return false');

assert.throws(TypeError, () => {
  new Array.from([]);
}, 'new Array.from([]) throws a TypeError exception');


// ===== test/built-ins/Array/from/proto-from-ctor-realm.js =====
// Copyright (C) 2016 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.from
es6id: 22.1.2.1
description: Default [[Prototype]] value derived from realm of the constructor
info: |
    [...]
    5. If usingIterator is not undefined, then
       a. If IsConstructor(C) is true, then
          i. Let A be ? Construct(C).
    [...]

    9.1.14 GetPrototypeFromConstructor

    [...]
    3. Let proto be ? Get(constructor, "prototype").
    4. If Type(proto) is not Object, then
       a. Let realm be ? GetFunctionRealm(constructor).
       b. Let proto be realm's intrinsic object named intrinsicDefaultProto.
    [...]
features: [cross-realm]
---*/

var other = $262.createRealm().global;
var C = new other.Function();
C.prototype = null;

var a = Array.from.call(C, []);

assert.sameValue(
  Object.getPrototypeOf(a),
  other.Object.prototype,
  'Object.getPrototypeOf(Array.from.call(C, [])) returns other.Object.prototype'
);

// ===== test/built-ins/Array/from/source-array-boundary.js =====
// Copyright 2015 Microsoft Corporation. All rights reserved.
// This code is governed by the license found in the LICENSE file.

/*---
description: Source array with boundary values
esid: sec-array.from
es6id: 22.1.2.1
---*/

var array = [Number.MAX_VALUE, Number.MIN_VALUE, Number.NaN, Number.NEGATIVE_INFINITY, Number.POSITIVE_INFINITY];
var arrayIndex = -1;

function mapFn(value, index) {
  this.arrayIndex++;
  assert.sameValue(value, array[this.arrayIndex], 'The value of value is expected to equal the value of array[this.arrayIndex]');
  assert.sameValue(index, this.arrayIndex, 'The value of index is expected to equal the value of this.arrayIndex');

  return value;
}

var a = Array.from(array, mapFn, this);

assert.sameValue(a.length, array.length, 'The value of a.length is expected to equal the value of array.length');
assert.sameValue(a[0], Number.MAX_VALUE, 'The value of a[0] is expected to equal the value of Number.MAX_VALUE');
assert.sameValue(a[1], Number.MIN_VALUE, 'The value of a[1] is expected to equal the value of Number.MIN_VALUE');
assert.sameValue(a[2], Number.NaN, 'The value of a[2] is expected to equal the value of Number.NaN');
assert.sameValue(a[3], Number.NEGATIVE_INFINITY, 'The value of a[3] is expected to equal the value of Number.NEGATIVE_INFINITY');
assert.sameValue(a[4], Number.POSITIVE_INFINITY, 'The value of a[4] is expected to equal the value of Number.POSITIVE_INFINITY');

// ===== test/built-ins/Array/from/source-object-constructor.js =====
// Copyright 2015 Microsoft Corporation. All rights reserved.
// This code is governed by the license found in the LICENSE file.

/*---
description: >
    Array.from uses a constructor other than Array.
esid: sec-array.from
es6id: 22.1.2.1
---*/

assert.sameValue(
  Array.from.call(Object, []).constructor,
  Object,
  'The value of Array.from.call(Object, []).constructor is expected to equal the value of Object'
);

// ===== test/built-ins/Array/from/source-object-iterator-1.js =====
// Copyright 2015 Microsoft Corporation. All rights reserved.
// This code is governed by the license found in the LICENSE file.

/*---
description: Source object has iterator which throws
esid: sec-array.from
es6id: 22.1.2.1
features: [Symbol.iterator]
---*/

var array = [2, 4, 8, 16, 32, 64, 128];
var obj = {
  [Symbol.iterator]() {
    return {
      index: 0,
      next() {
        throw new Test262Error();
      },
      isDone: false,
      get val() {
        this.index++;
        if (this.index > 7) {
          this.isDone = true;
        }
        return 1 << this.index;
      }
    };
  }
};
assert.throws(Test262Error, function() {
  Array.from(obj);
}, 'Array.from(obj) throws a Test262Error exception');

// ===== test/built-ins/Array/from/source-object-iterator-2.js =====
// Copyright 2015 Microsoft Corporation. All rights reserved.
// This code is governed by the license found in the LICENSE file.

/*---
description: Source object has iterator
esid: sec-array.from
es6id: 22.1.2.1
features: [Symbol.iterator]
---*/

var array = [2, 4, 8, 16, 32, 64, 128];
var obj = {
  [Symbol.iterator]() {
    return {
      index: 0,
      next() {
        return {
          value: this.val,
          done: this.isDone
        };
      },
      isDone: false,
      get val() {
        this.index++;
        if (this.index > 7) {
          this.isDone = true;
        }
        return 1 << this.index;
      }
    };
  }
};
var a = Array.from.call(Object, obj);
assert.sameValue(typeof a, typeof {}, 'The value of `typeof a` is expected to be typeof {}');
for (var j = 0; j < a.length; j++) {
  assert.sameValue(a[j], array[j], 'The value of a[j] is expected to equal the value of array[j]');
}

// ===== test/built-ins/Array/from/source-object-length.js =====
// Copyright 2015 Microsoft Corporation. All rights reserved.
// This code is governed by the license found in the LICENSE file.

/*---
description: >
    Source is an object with length property and one item is deleted
    from the source
esid: sec-array.from
es6id: 22.1.2.1
---*/

var array = [2, 4, 0, 16];
var expectedArray = [2, 4, , 16];
var obj = {
  length: 4,
  0: 2,
  1: 4,
  2: 0,
  3: 16
};
delete obj[2];
var a = Array.from(obj);
for (var j = 0; j < expectedArray.length; j++) {
  assert.sameValue(a[j], expectedArray[j], 'The value of a[j] is expected to equal the value of expectedArray[j]');
}

// ===== test/built-ins/Array/from/source-object-length-set-elem-prop-err.js =====
// Copyright (C) 2020 Alexey Shvayka. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.from
description: >
  TypeError is thrown if CreateDataProperty fails.
  (items is not iterable)
info: |
  Array.from ( items [ , mapfn [ , thisArg ] ] )

  [...]
  4. Let usingIterator be ? GetMethod(items, @@iterator).
  5. If usingIterator is not undefined, then
    [...]
  6. NOTE: items is not an Iterable so assume it is an array-like object.
  [...]
  12. Repeat, while k < len
    [...]
    e. Perform ? CreateDataPropertyOrThrow(A, Pk, mappedValue).
  [...]

  CreateDataPropertyOrThrow ( O, P, V )

  [...]
  3. Let success be ? CreateDataProperty(O, P, V).
  4. If success is false, throw a TypeError exception.
---*/

var items = {
  length: 1,
};

var A1 = function(_length) {
  this.length = 0;
  Object.preventExtensions(this);
};

assert.throws(TypeError, function() {
  Array.from.call(A1, items);
}, 'Array.from.call(A1, items) throws a TypeError exception');

var A2 = function(_length) {
  Object.defineProperty(this, "0", {
    writable: true,
    configurable: false,
  });
};

assert.throws(TypeError, function() {
  Array.from.call(A2, items);
}, 'Array.from.call(A2, items) throws a TypeError exception');

// ===== test/built-ins/Array/from/source-object-length-set-elem-prop-non-writable.js =====
// Copyright (C) 2020 Alexey Shvayka. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.from
description: >
  Non-writable properties are overwritten by CreateDataProperty.
  (result object's "0" is non-writable, items is not iterable)
info: |
  Array.from ( items [ , mapfn [ , thisArg ] ] )

  [...]
  4. Let usingIterator be ? GetMethod(items, @@iterator).
  5. If usingIterator is not undefined, then
    [...]
  6. NOTE: items is not an Iterable so assume it is an array-like object.
  [...]
  12. Repeat, while k < len
    [...]
    e. Perform ? CreateDataPropertyOrThrow(A, Pk, mappedValue).
  [...]
includes: [propertyHelper.js]
---*/

var items = {
  "0": 2,
  length: 1,
};

var A = function(_length) {
  Object.defineProperty(this, "0", {
    value: 1,
    writable: false,
    enumerable: false,
    configurable: true,
  });
};

var res = Array.from.call(A, items);

verifyProperty(res, "0", {
  value: 2,
  writable: true,
  enumerable: true,
  configurable: true,
});

// ===== test/built-ins/Array/from/source-object-missing.js =====
// Copyright 2015 Microsoft Corporation. All rights reserved.
// This code is governed by the license found in the LICENSE file.

/*---
description: Source is an object with missing values
esid: sec-array.from
es6id: 22.1.2.1
---*/

var array = [2, 4, , 16];
var obj = {
  length: 4,
  0: 2,
  1: 4,
  3: 16
};

var a = Array.from.call(Object, obj);
assert.sameValue(typeof a, "object", 'The value of `typeof a` is expected to be "object"');
for (var j = 0; j < a.length; j++) {
  assert.sameValue(a[j], array[j], 'The value of a[j] is expected to equal the value of array[j]');
}

// ===== test/built-ins/Array/from/source-object-without.js =====
// Copyright 2015 Microsoft Corporation. All rights reserved.
// This code is governed by the license found in the LICENSE file.

/*---
description: Source is an object without length property
esid: sec-array.from
es6id: 22.1.2.1
---*/

var obj = {
  0: 2,
  1: 4,
  2: 8,
  3: 16
}

var a = Array.from(obj);
assert.sameValue(a.length, 0, 'The value of a.length is expected to be 0');

// ===== test/built-ins/Array/from/this-null.js =====
// Copyright 2015 Leonardo Balter. All rights reserved.
// This code is governed by the license found in the LICENSE file.
/*---
esid: sec-array.from
es6id: 22.1.2.1
description: Does not throw if this is null
---*/

var result = Array.from.call(null, []);

assert(result instanceof Array, 'The result of evaluating (result instanceof Array) is expected to be true');
assert.sameValue(result.length, 0, 'The value of result.length is expected to be 0');

// ===== test/built-ins/Array/is-a-constructor.js =====
// Copyright (C) 2020 Rick Waldron. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-ecmascript-standard-built-in-objects
description: >
  Array implements [[Construct]]
info: |
  IsConstructor ( argument )

  The abstract operation IsConstructor takes argument argument (an ECMAScript language value).
  It determines if argument is a function object with a [[Construct]] internal method.
  It performs the following steps when called:

  If Type(argument) is not Object, return false.
  If argument has a [[Construct]] internal method, return true.
  Return false.
includes: [isConstructor.js]
features: [Reflect.construct]
---*/

assert.sameValue(isConstructor(Array), true, 'isConstructor(Array) must return true');
new Array();
  

// ===== test/built-ins/Array/isArray/15.4.3.2-0-1.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-0-1
description: Array.isArray must exist as a function
---*/

var f = Array.isArray;

assert.sameValue(typeof f, "function", 'The value of `typeof f` is expected to be "function"');

// ===== test/built-ins/Array/isArray/15.4.3.2-0-2.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-0-2
description: Array.isArray must exist as a function taking 1 parameter
---*/

assert.sameValue(Array.isArray.length, 1, 'The value of Array.isArray.length is expected to be 1');

// ===== test/built-ins/Array/isArray/15.4.3.2-0-3.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-0-3
description: Array.isArray return true if its argument is an Array
---*/

assert.sameValue(Array.isArray([]), true, 'Array.isArray([]) must return true');

// ===== test/built-ins/Array/isArray/15.4.3.2-0-4.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
description: Array.isArray return false if its argument is not an Array
---*/

assert.sameValue(Array.isArray(42), false, 'Array.isArray(42) must return false');
assert.sameValue(Array.isArray(undefined), false, 'Array.isArray(undefined) must return false');
assert.sameValue(Array.isArray(true), false, 'Array.isArray(true) must return false');
assert.sameValue(Array.isArray("abc"), false, 'Array.isArray("abc") must return false');
assert.sameValue(Array.isArray({}), false, 'Array.isArray({}) must return false');
assert.sameValue(Array.isArray(null), false, 'Array.isArray(null) must return false');

// ===== test/built-ins/Array/isArray/15.4.3.2-0-5.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-0-5
description: >
    Array.isArray return true if its argument is an Array
    (Array.prototype)
---*/

assert.sameValue(Array.isArray(Array.prototype), true, 'Array.isArray(Array.prototype) must return true');

// ===== test/built-ins/Array/isArray/15.4.3.2-0-6.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-0-6
description: Array.isArray return true if its argument is an Array (new Array())
---*/

assert.sameValue(Array.isArray(new Array(10)), true, 'Array.isArray(new Array(10)) must return true');

// ===== test/built-ins/Array/isArray/15.4.3.2-0-7.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-0-7
description: Array.isArray returns false if its argument is not an Array
---*/

assert.sameValue(Array.isArray({}), false, 'Array.isArray({}) must return false');

// ===== test/built-ins/Array/isArray/15.4.3.2-1-10.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-1-10
description: Array.isArray applied to RegExp object
---*/

assert.sameValue(Array.isArray(new RegExp()), false, 'Array.isArray(new RegExp()) must return false');

// ===== test/built-ins/Array/isArray/15.4.3.2-1-11.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-1-11
description: Array.isArray applied to the JSON object
---*/

assert.sameValue(Array.isArray(JSON), false, 'Array.isArray(JSON) must return false');

// ===== test/built-ins/Array/isArray/15.4.3.2-1-12.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-1-12
description: Array.isArray applied to Error object
---*/

assert.sameValue(Array.isArray(new SyntaxError()), false, 'Array.isArray(new SyntaxError()) must return false');

// ===== test/built-ins/Array/isArray/15.4.3.2-1-13.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-1-13
description: Array.isArray applied to Arguments object
---*/

var arg;

(function fun() {
  arg = arguments;
}(1, 2, 3));

assert.sameValue(Array.isArray(arg), false, 'Array.isArray(arguments) must return false');

// ===== test/built-ins/Array/isArray/15.4.3.2-1-15.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-1-15
description: Array.isArray applied to the global object
---*/

assert.sameValue(Array.isArray(this), false, 'Array.isArray(this) must return false');

// ===== test/built-ins/Array/isArray/15.4.3.2-1-1.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-1-1
description: Array.isArray applied to boolean primitive
---*/

assert.sameValue(Array.isArray(true), false, 'Array.isArray(true) must return false');

// ===== test/built-ins/Array/isArray/15.4.3.2-1-2.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-1-2
description: Array.isArray applied to Boolean Object
---*/

assert.sameValue(Array.isArray(new Boolean(false)), false, 'Array.isArray(new Boolean(false)) must return false');

// ===== test/built-ins/Array/isArray/15.4.3.2-1-3.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-1-3
description: Array.isArray applied to number primitive
---*/

assert.sameValue(Array.isArray(5), false, 'Array.isArray(5) must return false');

// ===== test/built-ins/Array/isArray/15.4.3.2-1-4.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-1-4
description: Array.isArray applied to Number object
---*/

assert.sameValue(Array.isArray(new Number(-3)), false, 'Array.isArray(new Number(-3)) must return false');

// ===== test/built-ins/Array/isArray/15.4.3.2-1-5.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-1-5
description: Array.isArray applied to string primitive
---*/

assert.sameValue(Array.isArray("abc"), false, 'Array.isArray("abc") must return false');

// ===== test/built-ins/Array/isArray/15.4.3.2-1-6.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-1-6
description: Array.isArray applied to String object
---*/

assert.sameValue(Array.isArray(new String("hello\nworld\\!")), false, 'Array.isArray(new String("hello\\nworld\\\\!")) must return false');

// ===== test/built-ins/Array/isArray/15.4.3.2-1-7.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-1-7
description: Array.isArray applied to Function object
---*/

assert.sameValue(Array.isArray(function() {}), false, 'Array.isArray(function() {}) must return false');

// ===== test/built-ins/Array/isArray/15.4.3.2-1-8.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-1-8
description: Array.isArray applied to the Math object
---*/

assert.sameValue(Array.isArray(Math), false, 'Array.isArray(Math) must return false');

// ===== test/built-ins/Array/isArray/15.4.3.2-1-9.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-1-9
description: Array.isArray applied to Date object
---*/

assert.sameValue(Array.isArray(new Date(0)), false, 'Array.isArray(new Date(0)) must return false');

// ===== test/built-ins/Array/isArray/15.4.3.2-2-1.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-2-1
description: Array.isArray applied to an object with an array as the prototype
---*/

var proto = [];
var Con = function() {};
Con.prototype = proto;

var child = new Con();

assert.sameValue(Array.isArray(child), false, 'Array.isArray(new Con()) must return false');

// ===== test/built-ins/Array/isArray/15.4.3.2-2-2.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-2-2
description: >
    Array.isArray applied to an object with Array.prototype as the
    prototype
---*/

var proto = Array.prototype;
var Con = function() {};
Con.prototype = proto;

var child = new Con();

assert.sameValue(Array.isArray(child), false, 'Array.isArray(new Con()) must return false');

// ===== test/built-ins/Array/isArray/15.4.3.2-2-3.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es5id: 15.4.3.2-2-3
description: >
    Array.isArray applied to an Array-like object with length and some
    indexed properties
---*/

assert.sameValue(Array.isArray({
  0: 12,
  1: 9,
  length: 2
}), false, 'Array.isArray({0: 12, 1: 9, length: 2}) must return false');

// ===== test/built-ins/Array/isArray/descriptor.js =====
// Copyright 2017 Lyza Danger Gardner. All rights reserved.
// This code is governed by the license found in the LICENSE file.

/*---
description: Testing descriptor property of Array.isArray
includes: [propertyHelper.js]
esid: sec-array.isarray
---*/

verifyProperty(Array, "isArray", {
  writable: true,
  enumerable: false,
  configurable: true
});

// ===== test/built-ins/Array/isArray/name.js =====
// Copyright (C) 2015 André Bargull. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.isarray
es6id: 22.1.2.2
description: >
  Array.isArray.name is "isArray".
info: |
  Array.isArray ( arg )

  17 ECMAScript Standard Built-in Objects:
    Every built-in Function object, including constructors, that is not
    identified as an anonymous function has a name property whose value
    is a String.

    Unless otherwise specified, the name property of a built-in Function
    object, if it exists, has the attributes { [[Writable]]: false,
    [[Enumerable]]: false, [[Configurable]]: true }.
includes: [propertyHelper.js]
---*/

verifyProperty(Array.isArray, "name", {
  value: "isArray",
  writable: false,
  enumerable: false,
  configurable: true
});

// ===== test/built-ins/Array/isArray/not-a-constructor.js =====
// Copyright (C) 2020 Rick Waldron. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-ecmascript-standard-built-in-objects
description: >
  Array.isArray does not implement [[Construct]], is not new-able
info: |
  ECMAScript Function Objects

  Built-in function objects that are not identified as constructors do not
  implement the [[Construct]] internal method unless otherwise specified in
  the description of a particular function.

  sec-evaluatenew

  ...
  7. If IsConstructor(constructor) is false, throw a TypeError exception.
  ...
includes: [isConstructor.js]
features: [Reflect.construct, arrow-function]
---*/

assert.sameValue(isConstructor(Array.isArray), false, 'isConstructor(Array.isArray) must return false');

assert.throws(TypeError, () => {
  new Array.isArray([]);
}, 'new Array.isArray([]) throws a TypeError exception');


// ===== test/built-ins/Array/isArray/proxy.js =====
// Copyright (C) 2016 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.isarray
es6id: 22.1.2.2
description: Proxy of an array is treated as an array
info: |
  1. Return IsArray(arg).

  7.2.2 IsArray

  [...]
  3. If argument is a Proxy exotic object, then
     a. If the value of the [[ProxyHandler]] internal slot of argument is null,
        throw a TypeError exception.
     b. Let target be the value of the [[ProxyTarget]] internal slot of
        argument.
     c. Return ? IsArray(target).
features: [Proxy]
---*/

var objectProxy = new Proxy({}, {});
var arrayProxy = new Proxy([], {});
var arrayProxyProxy = new Proxy(arrayProxy, {});

assert.sameValue(Array.isArray(objectProxy), false, 'Array.isArray(new Proxy({}, {})) must return false');
assert.sameValue(Array.isArray(arrayProxy), true, 'Array.isArray(new Proxy([], {})) must return true');
assert.sameValue(
  Array.isArray(arrayProxyProxy), true, 'Array.isArray(new Proxy(arrayProxy, {})) must return true'
);

// ===== test/built-ins/Array/isArray/proxy-revoked.js =====
// Copyright (C) 2016 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.isarray
es6id: 22.1.2.2
description: Revoked proxy value produces a TypeError
info: |
  1. Return IsArray(arg).

  7.2.2 IsArray

  [...]
  3. If argument is a Proxy exotic object, then
     a. If the value of the [[ProxyHandler]] internal slot of argument is null,
        throw a TypeError exception.
     b. Let target be the value of the [[ProxyTarget]] internal slot of
        argument.
     c. Return ? IsArray(target).
features: [Proxy]
---*/

var handle = Proxy.revocable([], {});

handle.revoke();

assert.throws(TypeError, function() {
  Array.isArray(handle.proxy);
}, 'Array.isArray(handle.proxy) throws a TypeError exception');

// ===== test/built-ins/Array/length/15.4.5.1-3.d-1.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-properties-of-array-instances-length
es5id: 15.4.5.1-3.d-1
description: >
    Throw RangeError if attempt to set array length property to
    4294967296 (2**32)
---*/


assert.throws(RangeError, function() {
  [].length = 4294967296;
}, '[].length = 4294967296 throws a RangeError exception');

// ===== test/built-ins/Array/length/15.4.5.1-3.d-2.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-properties-of-array-instances-length
es5id: 15.4.5.1-3.d-2
description: >
    Throw RangeError if attempt to set array length property to
    4294967297 (1+2**32)
---*/


assert.throws(RangeError, function() {
  [].length = 4294967297;
}, '[].length = 4294967297 throws a RangeError exception');

// ===== test/built-ins/Array/length/15.4.5.1-3.d-3.js =====
// Copyright (c) 2012 Ecma International.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-properties-of-array-instances-length
es5id: 15.4.5.1-3.d-3
description: Set array length property to max value 4294967295 (2**32-1,)
---*/

var a = [];
a.length = 4294967295;

assert.sameValue(a.length, 4294967295, 'The value of a.length is expected to be 4294967295');

// ===== test/built-ins/Array/length/define-own-prop-length-coercion-order.js =====
// Copyright (C) 2020 Alexey Shvayka. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
author: André Bargull
esid: sec-arraysetlength
description: >
  [[Value]] is coerced to number before descriptor validation.
info: |
  ArraySetLength ( A, Desc )

  [...]
  3. Let newLen be ? ToUint32(Desc.[[Value]]).
  4. Let numberLen be ? ToNumber(Desc.[[Value]]).
  [...]
  7. Let oldLenDesc be OrdinaryGetOwnProperty(A, "length").
  [...]
  11. If newLen ≥ oldLen, then
    a. Return OrdinaryDefineOwnProperty(A, "length", newLenDesc).

  OrdinaryDefineOwnProperty ( O, P, Desc )

  [...]
  3. Return ValidateAndApplyPropertyDescriptor(O, P, extensible, Desc, current).

  ValidateAndApplyPropertyDescriptor ( O, P, extensible, Desc, current )

  [...]
  7. Else if IsDataDescriptor(current) and IsDataDescriptor(Desc) are both true, then
    a. If current.[[Configurable]] is false and current.[[Writable]] is false, then
      i. If Desc.[[Writable]] is present and Desc.[[Writable]] is true, return false.
features: [Reflect]
---*/

var array = [1, 2];
var valueOfCalls = 0;
var length = {
  valueOf: function() {
    valueOfCalls += 1;
    if (valueOfCalls !== 1) {
      // skip first coercion at step 3
      Object.defineProperty(array, "length", {writable: false});
    }
    return array.length;
  },
};

assert.throws(TypeError, function() {
  Object.defineProperty(array, "length", {value: length, writable: true});
}, 'Object.defineProperty(array, "length", {value: length, writable: true}) throws a TypeError exception');
assert.sameValue(valueOfCalls, 2, 'The value of valueOfCalls is expected to be 2');


array = [1, 2];
valueOfCalls = 0;

assert(
  !Reflect.defineProperty(array, "length", {value: length, writable: true}),
  'The value of !Reflect.defineProperty(array, "length", {value: length, writable: true}) is expected to be true'
);
assert.sameValue(valueOfCalls, 2, 'The value of valueOfCalls is expected to be 2');

// ===== test/built-ins/Array/length/define-own-prop-length-coercion-order-set.js =====
// Copyright (C) 2020 Alexey Shvayka. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
author: André Bargull
esid: sec-arraysetlength
description: >
  [[Value]] is coerced to number before current descriptor's [[Writable]] check.
info: |
  ArraySetLength ( A, Desc )

  [...]
  3. Let newLen be ? ToUint32(Desc.[[Value]]).
  4. Let numberLen be ? ToNumber(Desc.[[Value]]).
  [...]
  7. Let oldLenDesc be OrdinaryGetOwnProperty(A, "length").
  [...]
  12. If oldLenDesc.[[Writable]] is false, return false.
features: [Symbol, Symbol.toPrimitive, Reflect, Reflect.set]
includes: [compareArray.js]
---*/

var array = [1, 2, 3];
var hints = [];
var length = {};
length[Symbol.toPrimitive] = function(hint) {
  hints.push(hint);
  Object.defineProperty(array, "length", {writable: false});
  return 0;
};

assert.throws(TypeError, function() {
  "use strict";
  array.length = length;
}, '`"use strict"; array.length = length` throws a TypeError exception');
assert.compareArray(hints, ["number", "number"], 'The value of hints is expected to be ["number", "number"]');


array = [1, 2, 3];
hints = [];

assert(
  !Reflect.set(array, "length", length),
  'The value of !Reflect.set(array, "length", length) is expected to be true'
);
assert.compareArray(hints, ["number", "number"], 'The value of hints is expected to be ["number", "number"]');

// ===== test/built-ins/Array/length/define-own-prop-length-error.js =====
// Copyright (C) 2023 Jordan Harband. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
author: Jordan Harband
esid: sec-arraysetlength
description: >
  Setting an invalid array length throws a RangeError
info: |
  ArraySetLength ( A, Desc )

  [...]
  5. If SameValueZero(newLen, numberLen) is false, throw a RangeError exception.
  [...]
---*/

assert.throws(RangeError, function () {
  Object.defineProperty([], 'length', { value: -1, configurable: true });
});

assert.throws(RangeError, function () {
  // the string is intentionally "computed" here to ensure there are no optimization bugs
  Object.defineProperty([], 'len' + 'gth', { value: -1, configurable: true });
});

// ===== test/built-ins/Array/length/define-own-prop-length-no-value-order.js =====
// Copyright (C) 2020 Alexey Shvayka. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-arraysetlength
description: >
  Ordinary descriptor validation if [[Value]] is absent.
info: |
  ArraySetLength ( A, Desc )

  1. If Desc.[[Value]] is absent, then
    a. Return OrdinaryDefineOwnProperty(A, "length", Desc).

  OrdinaryDefineOwnProperty ( O, P, Desc )

  [...]
  3. Return ValidateAndApplyPropertyDescriptor(O, P, extensible, Desc, current).

  ValidateAndApplyPropertyDescriptor ( O, P, extensible, Desc, current )

  [...]
  4. If current.[[Configurable]] is false, then
    a. If Desc.[[Configurable]] is present and its value is true, return false.
    b. If Desc.[[Enumerable]] is present and
      ! SameValue(Desc.[[Enumerable]], current.[[Enumerable]]) is false, return false.
  [...]
  6. Else if ! SameValue(! IsDataDescriptor(current), ! IsDataDescriptor(Desc)) is false, then
    a. If current.[[Configurable]] is false, return false.
  [...]
  7. Else if IsDataDescriptor(current) and IsDataDescriptor(Desc) are both true, then
    a. If current.[[Configurable]] is false and current.[[Writable]] is false, then
      i. If Desc.[[Writable]] is present and Desc.[[Writable]] is true, return false.
features: [Reflect]
---*/

assert.throws(TypeError, function() {
  Object.defineProperty([], "length", {configurable: true});
}, 'Object.defineProperty([], "length", {configurable: true}) throws a TypeError exception');

assert(
  !Reflect.defineProperty([], "length", {enumerable: true}),
  'The value of !Reflect.defineProperty([], "length", {enumerable: true}) is expected to be true'
);

assert.throws(TypeError, function() {
  Object.defineProperty([], "length", {
    get: function() {
      throw new Test262Error("[[Get]] shouldn't be called");
    },
  });
}, 'Object.defineProperty([], "length", {get: function() {throw new Test262Error("[[Get]] shouldn"t be called");},}) throws a TypeError exception');

assert(
  !Reflect.defineProperty([], "length", {set: function(_value) {}}),
  'The value of !Reflect.defineProperty([], "length", {set: function(_value) {}}) is expected to be true'
);

var array = [];
Object.defineProperty(array, "length", {writable: false});
assert.throws(TypeError, function() {
  Object.defineProperty(array, "length", {writable: true});
}, 'Object.defineProperty(array, "length", {writable: true}) throws a TypeError exception');

// ===== test/built-ins/Array/length/define-own-prop-length-overflow-order.js =====
// Copyright (C) 2020 Alexey Shvayka. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-arraysetlength
description: >
  [[Value]] is checked for overflow before descriptor validation.
info: |
  ArraySetLength ( A, Desc )

  [...]
  3. Let newLen be ? ToUint32(Desc.[[Value]]).
  4. Let numberLen be ? ToNumber(Desc.[[Value]]).
  5. If newLen ≠ numberLen, throw a RangeError exception.
---*/

assert.throws(RangeError, function() {
  Object.defineProperty([], "length", {value: -1, configurable: true});
}, 'Object.defineProperty([], "length", {value: -1, configurable: true}) throws a RangeError exception');

assert.throws(RangeError, function() {
  Object.defineProperty([], "length", {value: NaN, enumerable: true});
}, 'Object.defineProperty([], "length", {value: NaN, enumerable: true}) throws a RangeError exception');

var array = [];
Object.defineProperty(array, "length", {writable: false});
assert.throws(RangeError, function() {
  Object.defineProperty(array, "length", {value: Number.MAX_SAFE_INTEGER, writable: true});
}, 'Object.defineProperty(array, "length", {value: Number.MAX_SAFE_INTEGER, writable: true}) throws a RangeError exception');

// ===== test/built-ins/Array/length/define-own-prop-length-overflow-realm.js =====
// Copyright (C) 2016 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array-exotic-objects-defineownproperty-p-desc
es6id: 9.4.2.1
description: >
  Error when setting a length larger than 2**32 (honoring the Realm of the
  current execution context)
info: |
  [...]
  2. If P is "length", then
     a. Return ? ArraySetLength(A, Desc).
features: [cross-realm]
---*/

var OArray = $262.createRealm().global.Array;
var array = new OArray();

assert.throws(RangeError, function() {
  array.length = 4294967296;
}, 'array.length = 4294967296 throws a RangeError exception');

// ===== test/built-ins/Array/length.js =====
// Copyright (C) 2017 Leo Balter. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-constructor
description: >
  Array has a "length" property whose value is 1.
info: |
  22.1.1 The Array Constructor

  The length property of the Array constructor function is 1.
  ...

  ES7 section 17: Unless otherwise specified, the length property of a built-in
  Function object has the attributes { [[Writable]]: false, [[Enumerable]]:
  false, [[Configurable]]: true }.
includes: [propertyHelper.js]
---*/

verifyProperty(Array, "length", {
  value: 1,
  writable: false,
  enumerable: false,
  configurable: true
});

// ===== test/built-ins/Array/length/S15.4.2.2_A1.1_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-len
info: |
    The [[Prototype]] property of the newly constructed object
    is set to the original Array prototype object, the one that
    is the initial value of Array.prototype
es5id: 15.4.2.2_A1.1_T1
description: >
    Create new property of Array.prototype. When new Array object has
    this property
---*/

Array.prototype.myproperty = 1;
var x = new Array(0);
assert.sameValue(x.myproperty, 1, 'The value of x.myproperty is expected to be 1');

// ===== test/built-ins/Array/length/S15.4.2.2_A1.1_T2.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-len
info: |
    The [[Prototype]] property of the newly constructed object
    is set to the original Array prototype object, the one that
    is the initial value of Array.prototype
es5id: 15.4.2.2_A1.1_T2
description: Array.prototype.toString = Object.prototype.toString
---*/

Array.prototype.toString = Object.prototype.toString;
var x = new Array(0);
assert.sameValue(x.toString(), "[object Array]", 'x.toString() must return "[object Array]"');

// ===== test/built-ins/Array/length/S15.4.2.2_A1.1_T3.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-len
info: |
    The [[Prototype]] property of the newly constructed object
    is set to the original Array prototype object, the one that
    is the initial value of Array.prototype
es5id: 15.4.2.2_A1.1_T3
description: Checking use isPrototypeOf
---*/

assert.sameValue(
  Array.prototype.isPrototypeOf(new Array(0)),
  true,
  'Array.prototype.isPrototypeOf(new Array(0)) must return true'
);

// ===== test/built-ins/Array/length/S15.4.2.2_A1.2_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-len
info: The [[Class]] property of the newly constructed object is set to "Array"
es5id: 15.4.2.2_A1.2_T1
description: Checking use Object.prototype.toString
---*/

var x = new Array(0);
assert.sameValue(Object.prototype.toString.call(x), "[object Array]", 'Object.prototype.toString.call(new Array(0)) must return "[object Array]"');

// ===== test/built-ins/Array/length/S15.4.2.2_A2.1_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-len
info: |
    If the argument len is a Number and ToUint32(len) is equal to len,
    then the length property of the newly constructed object is set to ToUint32(len)
es5id: 15.4.2.2_A2.1_T1
description: Array constructor is given one argument
---*/

var x = new Array(0);
assert.sameValue(x.length, 0, 'The value of x.length is expected to be 0');

var x = new Array(1);
assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');

var x = new Array(4294967295);
assert.sameValue(x.length, 4294967295, 'The value of x.length is expected to be 4294967295');

// ===== test/built-ins/Array/length/S15.4.2.2_A2.2_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-len
info: |
    If the argument len is a Number and ToUint32(len) is not equal to len,
    a RangeError exception is thrown
es5id: 15.4.2.2_A2.2_T1
description: Use try statement. len = -1, 4294967296, 4294967297
---*/

try {
  new Array(-1);
  throw new Test262Error('#1.1: new Array(-1) throw RangeError. Actual: ' + (new Array(-1)));
} catch (e) {
  assert.sameValue(
    e instanceof RangeError,
    true,
    'The result of evaluating (e instanceof RangeError) is expected to be true'
  );
}

try {
  new Array(4294967296);
  throw new Test262Error('#2.1: new Array(4294967296) throw RangeError. Actual: ' + (new Array(4294967296)));
} catch (e) {
  assert.sameValue(
    e instanceof RangeError,
    true,
    'The result of evaluating (e instanceof RangeError) is expected to be true'
  );
}

try {
  new Array(4294967297);
  throw new Test262Error('#3.1: new Array(4294967297) throw RangeError. Actual: ' + (new Array(4294967297)));
} catch (e) {
  assert.sameValue(
    e instanceof RangeError,
    true,
    'The result of evaluating (e instanceof RangeError) is expected to be true'
  );
}

// ===== test/built-ins/Array/length/S15.4.2.2_A2.2_T2.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-len
info: |
    If the argument len is a Number and ToUint32(len) is not equal to len,
    a RangeError exception is thrown
es5id: 15.4.2.2_A2.2_T2
description: Use try statement. len = NaN, +/-Infinity
---*/

try {
  new Array(NaN);
  throw new Test262Error('#1.1: new Array(NaN) throw RangeError. Actual: ' + (new Array(NaN)));
} catch (e) {
  assert.sameValue(
    e instanceof RangeError,
    true,
    'The result of evaluating (e instanceof RangeError) is expected to be true'
  );
}

try {
  new Array(Number.POSITIVE_INFINITY);
  throw new Test262Error('#2.1: new Array(Number.POSITIVE_INFINITY) throw RangeError. Actual: ' + (new Array(Number.POSITIVE_INFINITY)));
} catch (e) {
  assert.sameValue(
    e instanceof RangeError,
    true,
    'The result of evaluating (e instanceof RangeError) is expected to be true'
  );
}

try {
  new Array(Number.NEGATIVE_INFINITY);
  throw new Test262Error('#3.1: new Array(Number.NEGATIVE_INFINITY) throw RangeError. Actual: ' + (new Array(Number.NEGATIVE_INFINITY)));
} catch (e) {
  assert.sameValue(
    e instanceof RangeError,
    true,
    'The result of evaluating (e instanceof RangeError) is expected to be true'
  );
}

// ===== test/built-ins/Array/length/S15.4.2.2_A2.2_T3.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-len
info: |
    If the argument len is a Number and ToUint32(len) is not equal to len,
    a RangeError exception is thrown
es5id: 15.4.2.2_A2.2_T3
description: Use try statement. len = 1.5, Number.MAX_VALUE, Number.MIN_VALUE
---*/

try {
  new Array(1.5);
  throw new Test262Error('#1.1: new Array(1.5) throw RangeError. Actual: ' + (new Array(1.5)));
} catch (e) {
  assert.sameValue(
    e instanceof RangeError,
    true,
    'The result of evaluating (e instanceof RangeError) is expected to be true'
  );
}

try {
  new Array(Number.MAX_VALUE);
  throw new Test262Error('#2.1: new Array(Number.MAX_VALUE) throw RangeError. Actual: ' + (new Array(Number.MAX_VALUE)));
} catch (e) {
  assert.sameValue(
    e instanceof RangeError,
    true,
    'The result of evaluating (e instanceof RangeError) is expected to be true'
  );
}

try {
  new Array(Number.MIN_VALUE);
  throw new Test262Error('#3.1: new Array(Number.MIN_VALUE) throw RangeError. Actual: ' + (new Array(Number.MIN_VALUE)));
} catch (e) {
  assert.sameValue(
    e instanceof RangeError,
    true,
    'The result of evaluating (e instanceof RangeError) is expected to be true'
  );
}

// ===== test/built-ins/Array/length/S15.4.2.2_A2.3_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-len
info: |
    If the argument len is not a Number, then the length property of
    the newly constructed object is set to 1 and the 0 property of
    the newly constructed object is set to len
es5id: 15.4.2.2_A2.3_T1
description: Checking for null and undefined
---*/

var x = new Array(null);

assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');
assert.sameValue(x[0], null, 'The value of x[0] is expected to be null');

var x = new Array(undefined);

assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');
assert.sameValue(x[0], undefined, 'The value of x[0] is expected to equal undefined');

// ===== test/built-ins/Array/length/S15.4.2.2_A2.3_T2.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-len
info: |
    If the argument len is not a Number, then the length property of
    the newly constructed object is set to 1 and the 0 property of
    the newly constructed object is set to len
es5id: 15.4.2.2_A2.3_T2
description: Checking for boolean primitive and Boolean object
---*/

var x = new Array(true);

assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');
assert.sameValue(x[0], true, 'The value of x[0] is expected to be true');

var obj = new Boolean(false);
var x = new Array(obj);

assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');
assert.sameValue(x[0], obj, 'The value of x[0] is expected to equal the value of obj');

// ===== test/built-ins/Array/length/S15.4.2.2_A2.3_T3.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-len
info: |
    If the argument len is not a Number, then the length property of
    the newly constructed object is set to 1 and the 0 property of
    the newly constructed object is set to len
es5id: 15.4.2.2_A2.3_T3
description: Checking for boolean primitive and Boolean object
---*/

var x = new Array("1");

assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');
assert.sameValue(x[0], "1", 'The value of x[0] is expected to be "1"');

var obj = new String("0");
var x = new Array(obj);

assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');
assert.sameValue(x[0], obj, 'The value of x[0] is expected to equal the value of obj');

// ===== test/built-ins/Array/length/S15.4.2.2_A2.3_T4.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-len
info: |
    If the argument len is not a Number, then the length property of
    the newly constructed object is set to 1 and the 0 property of
    the newly constructed object is set to len
es5id: 15.4.2.2_A2.3_T4
description: Checking for Number object
---*/

var obj = new Number(0);
var x = new Array(obj);

assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');
assert.sameValue(x[0], obj, 'The value of x[0] is expected to equal the value of obj');

var obj = new Number(1);
var x = new Array(obj);

assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');
assert.sameValue(x[0], obj, 'The value of x[0] is expected to equal the value of obj');

var obj = new Number(4294967295);
var x = new Array(obj);

assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');
assert.sameValue(x[0], obj, 'The value of x[0] is expected to equal the value of obj');

// ===== test/built-ins/Array/length/S15.4.2.2_A2.3_T5.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-len
info: |
    If the argument len is not a Number, then the length property of
    the newly constructed object is set to 1 and the 0 property of
    the newly constructed object is set to len
es5id: 15.4.2.2_A2.3_T5
description: Checking for Number object
---*/

var obj = new Number(-1);
var x = new Array(obj);

assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');
assert.sameValue(x[0], obj, 'The value of x[0] is expected to equal the value of obj');

var obj = new Number(4294967296);
var x = new Array(obj);

assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');
assert.sameValue(x[0], obj, 'The value of x[0] is expected to equal the value of obj');

var obj = new Number(4294967297);
var x = new Array(obj);

assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');
assert.sameValue(x[0], obj, 'The value of x[0] is expected to equal the value of obj');

// ===== test/built-ins/Array/length/S15.4.4_A1.3_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-properties-of-the-array-prototype-object
info: Array prototype object has a length property
es5id: 15.4.4_A1.3_T1
description: Array.prototype.length === 0
---*/

assert.sameValue(Array.prototype.length, 0, 'The value of Array.prototype.length is expected to be 0');

// ===== test/built-ins/Array/length/S15.4.5.1_A1.1_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-exotic-objects-defineownproperty-p-desc
info: If ToUint32(length) !== ToNumber(length), throw RangeError
es5id: 15.4.5.1_A1.1_T1
description: length in [4294967296, -1, 1.5]
---*/

try {
  var x = [];
  x.length = 4294967296;
  throw new Test262Error('#1.1: x = []; x.length = 4294967296 throw RangeError. Actual: x.length === ' + (x.length));
} catch (e) {
  assert.sameValue(
    e instanceof RangeError,
    true,
    'The result of evaluating (e instanceof RangeError) is expected to be true'
  );
}

try {
  x = [];
  x.length = -1;
  throw new Test262Error('#2.1: x = []; x.length = -1 throw RangeError. Actual: x.length === ' + (x.length));
} catch (e) {
  assert.sameValue(
    e instanceof RangeError,
    true,
    'The result of evaluating (e instanceof RangeError) is expected to be true'
  );
}

try {
  x = [];
  x.length = 1.5;
  throw new Test262Error('#3.1: x = []; x.length = 1.5 throw RangeError. Actual: x.length === ' + (x.length));
} catch (e) {
  assert.sameValue(
    e instanceof RangeError,
    true,
    'The result of evaluating (e instanceof RangeError) is expected to be true'
  );
}

// ===== test/built-ins/Array/length/S15.4.5.1_A1.1_T2.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-exotic-objects-defineownproperty-p-desc
info: If ToUint32(length) !== ToNumber(length), throw RangeError
es5id: 15.4.5.1_A1.1_T2
description: length in [NaN, Infinity, -Infinity, undefined]
---*/

try {
  var x = [];
  x.length = NaN;
  throw new Test262Error('#1.1: x = []; x.length = NaN throw RangeError. Actual: x.length === ' + (x.length));
} catch (e) {
  assert.sameValue(
    e instanceof RangeError,
    true,
    'The result of evaluating (e instanceof RangeError) is expected to be true'
  );
}

try {
  x = [];
  x.length = Number.POSITIVE_INFINITY;
  throw new Test262Error('#2.1: x = []; x.length = Number.POSITIVE_INFINITY throw RangeError. Actual: x.length === ' + (x.length));
} catch (e) {
  assert.sameValue(
    e instanceof RangeError,
    true,
    'The result of evaluating (e instanceof RangeError) is expected to be true'
  );
}

try {
  x = [];
  x.length = Number.NEGATIVE_INFINITY;
  throw new Test262Error('#3.1: x = []; x.length = Number.NEGATIVE_INFINITY throw RangeError. Actual: x.length === ' + (x.length));
} catch (e) {
  assert.sameValue(
    e instanceof RangeError,
    true,
    'The result of evaluating (e instanceof RangeError) is expected to be true'
  );
}

try {
  x = [];
  x.length = undefined;
  throw new Test262Error('#4.1: x = []; x.length = undefined throw RangeError. Actual: x.length === ' + (x.length));
} catch (e) {
  assert.sameValue(
    e instanceof RangeError,
    true,
    'The result of evaluating (e instanceof RangeError) is expected to be true'
  );
}

// ===== test/built-ins/Array/length/S15.4.5.1_A1.2_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-exotic-objects-defineownproperty-p-desc
info: |
    For every integer k that is less than the value of
    the length property of A but not less than ToUint32(length),
    if A itself has a property (not an inherited property) named ToString(k),
    then delete that property
es5id: 15.4.5.1_A1.2_T1
description: Change length of array
---*/

var x = [0, , 2, , 4];
x.length = 4;
assert.sameValue(x[4], undefined, 'The value of x[4] is expected to equal undefined');

x.length = 3;
assert.sameValue(x[3], undefined, 'The value of x[3] is expected to equal undefined');
assert.sameValue(x[2], 2, 'The value of x[2] is expected to be 2');

// ===== test/built-ins/Array/length/S15.4.5.1_A1.2_T3.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-exotic-objects-defineownproperty-p-desc
info: |
    For every integer k that is less than the value of
    the length property of A but not less than ToUint32(length),
    if A itself has a property (not an inherited property) named ToString(k),
    then delete that property
es5id: 15.4.5.1_A1.2_T3
description: Checking an inherited property
---*/

Array.prototype[2] = 2;
var x = [0, 1];
x.length = 3;
assert.sameValue(x.hasOwnProperty('2'), false, 'x.hasOwnProperty("2") must return false');

x.length = 2;
assert.sameValue(x[2], 2, 'The value of x[2] is expected to be 2');

// ===== test/built-ins/Array/length/S15.4.5.1_A1.3_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-exotic-objects-defineownproperty-p-desc
info: Set the value of property length of A to Uint32(length)
es5id: 15.4.5.1_A1.3_T1
description: length is object or primitve
---*/

var x = [];
x.length = true;
assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');

x = [0];
x.length = null;
assert.sameValue(x.length, 0, 'The value of x.length is expected to be 0');

x = [0];
x.length = new Boolean(false);
assert.sameValue(x.length, 0, 'The value of x.length is expected to be 0');

x = [];
x.length = new Number(1);
assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');

x = [];
x.length = "1";
assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');

x = [];
x.length = new String("1");
assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');

// ===== test/built-ins/Array/length/S15.4.5.1_A1.3_T2.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-exotic-objects-defineownproperty-p-desc
info: Set the value of property length of A to Uint32(length)
es5id: 15.4.5.1_A1.3_T2
description: Uint32 use ToNumber and ToPrimitve
---*/

var x = [];
x.length = {
  valueOf: function() {
    return 2
  }
};
assert.sameValue(x.length, 2, 'The value of x.length is expected to be 2');

x = [];
x.length = {
  valueOf: function() {
    return 2
  },
  toString: function() {
    return 1
  }
};
assert.sameValue(x.length, 2, 'The value of x.length is expected to be 2');

x = [];
x.length = {
  valueOf: function() {
    return 2
  },
  toString: function() {
    return {}
  }
};
assert.sameValue(x.length, 2, 'The value of x.length is expected to be 2');

try {
  x = [];
  x.length = {
    valueOf: function() {
      return 2
    },
    toString: function() {
      throw "error"
    }
  };
  assert.sameValue(x.length, 2, 'The value of x.length is expected to be 2');
}
catch (e) {
  assert.notSameValue(e, "error", 'The value of e is not "error"');
}

x = [];
x.length = {
  toString: function() {
    return 1
  }
};
assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');

x = [];
x.length = {
  valueOf: function() {
    return {}
  },
  toString: function() {
    return 1
  }
}
assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');

try {
  x = [];
  x.length = {
    valueOf: function() {
      throw "error"
    },
    toString: function() {
      return 1
    }
  };
  x.length;
  throw new Test262Error('#7.1: x = []; x.length = {valueOf: function() {throw "error"}, toString: function() {return 1}}; x.length throw "error". Actual: ' + (x.length));
}
catch (e) {
  assert.sameValue(e, "error", 'The value of e is expected to be "error"');
}

try {
  x = [];
  x.length = {
    valueOf: function() {
      return {}
    },
    toString: function() {
      return {}
    }
  };
  x.length;
  throw new Test262Error('#8.1: x = []; x.length = {valueOf: function() {return {}}, toString: function() {return {}}}  x.length throw TypeError. Actual: ' + (x.length));
}
catch (e) {
  assert.sameValue(
    e instanceof TypeError,
    true,
    'The result of evaluating (e instanceof TypeError) is expected to be true'
  );
}

// ===== test/built-ins/Array/length/S15.4.5.2_A3_T4.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-properties-of-array-instances-length
info: |
    If the length property is changed, every property whose name
    is an array index whose value is not smaller than the new length is automatically deleted
es5id: 15.4.5.2_A3_T4
description: >
    If new length greater than the name of every property whose name
    is an array index
---*/

var x = [0, 1, 2];
x[4294967294] = 4294967294;
x.length = 2;

assert.sameValue(x[0], 0, 'The value of x[0] is expected to be 0');
assert.sameValue(x[1], 1, 'The value of x[1] is expected to be 1');
assert.sameValue(x[2], undefined, 'The value of x[2] is expected to equal undefined');
assert.sameValue(x[4294967294], undefined, 'The value of x[4294967294] is expected to equal undefined');

// ===== test/built-ins/Array/name.js =====
// Copyright (C) 2017 Leo Balter. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-constructor
description: >
  The "name" property of Array
info: |
  17 ECMAScript Standard Built-in Objects

  Every built-in Function object, including constructors, that is not
  identified as an anonymous function has a name property whose value is a
  String. Unless otherwise specified, this value is the name that is given to
  the function in this specification.

  [...]

  Unless otherwise specified, the name property of a built-in Function
  object, if it exists, has the attributes { [[Writable]]: false,
  [[Enumerable]]: false, [[Configurable]]: true }.
includes: [propertyHelper.js]
---*/

verifyProperty(Array, "name", {
  value: "Array",
  writable: false,
  enumerable: false,
  configurable: true
});

// ===== test/built-ins/Array/of/construct-this-with-the-number-of-arguments.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.of
es6id: 22.1.2.3
description: Passes the number of arguments to the constructor it calls.
info: |
  Array.of ( ...items )

  1. Let len be the actual number of arguments passed to this function.
  2. Let items be the List of arguments passed to this function.
  3. Let C be the this value.
  4. If IsConstructor(C) is true, then
    a. Let A be Construct(C, «len»).
  ...
---*/

var len;
var hits = 0;

function C(length) {
  len = length;
  hits++;
}

Array.of.call(C);
assert.sameValue(len, 0, 'The value of len is expected to be 0');
assert.sameValue(hits, 1, 'The value of hits is expected to be 1');

Array.of.call(C, 'a', 'b')
assert.sameValue(len, 2, 'The value of len is expected to be 2');
assert.sameValue(hits, 2, 'The value of hits is expected to be 2');

Array.of.call(C, false, null, undefined);
assert.sameValue(
  len, 3,
  'The value of len is expected to be 3'
);
assert.sameValue(hits, 3, 'The value of hits is expected to be 3');

// ===== test/built-ins/Array/of/creates-a-new-array-from-arguments.js =====
// Copyright (c) 2015 the V8 project authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.
/*---
esid: sec-array.of
es6id: 22.1.2.3
description: >
  Array.of method creates a new Array with a variable number of arguments.
info: |
  22.1.2.3 Array.of ( ...items )

  ...
  7. Let k be 0.
  8. Repeat, while k < len
    a. Let kValue be items[k].
    b. Let Pk be ToString(k).
    c. Let defineStatus be CreateDataPropertyOrThrow(A,Pk, kValue).
    d. ReturnIfAbrupt(defineStatus).
    e. Increase k by 1.
  9. Let setStatus be Set(A, "length", len, true).
  10. ReturnIfAbrupt(setStatus).
  11. Return A.
---*/

var a1 = Array.of('Mike', 'Rick', 'Leo');
assert.sameValue(
  a1.length, 3,
  'The value of a1.length is expected to be 3'
);
assert.sameValue(a1[0], 'Mike', 'The value of a1[0] is expected to be "Mike"');
assert.sameValue(a1[1], 'Rick', 'The value of a1[1] is expected to be "Rick"');
assert.sameValue(a1[2], 'Leo', 'The value of a1[2] is expected to be "Leo"');

var a2 = Array.of(undefined, false, null, undefined);
assert.sameValue(
  a2.length, 4,
  'The value of a2.length is expected to be 4'
);
assert.sameValue(a2[0], undefined, 'The value of a2[0] is expected to equal undefined');
assert.sameValue(a2[1], false, 'The value of a2[1] is expected to be false');
assert.sameValue(a2[2], null, 'The value of a2[2] is expected to be null');
assert.sameValue(a2[3], undefined, 'The value of a2[3] is expected to equal undefined');

var a3 = Array.of();
assert.sameValue(a3.length, 0, 'The value of a3.length is expected to be 0');

// ===== test/built-ins/Array/of/does-not-use-prototype-properties.js =====
// Copyright (c) 2015 the V8 project authors. All rights reserved.
// Use of this source code is governed by a BSD-style license that can be
// found in the LICENSE file.
/*---
esid: sec-array.of
es6id: 22.1.2.3
description: Array.of does not use prototype properties for arguments.
info: |
  It defines elements rather than assigning to them.
---*/

Object.defineProperty(Array.prototype, "0", {
  set: function(v) {
    throw new Test262Error('Should define own properties');
  }
});

var arr = Array.of(true);
assert.sameValue(arr[0], true, 'The value of arr[0] is expected to be true');

function Custom() {}

Object.defineProperty(Custom.prototype, "0", {
  set: function(v) {
    throw new Test262Error('Should define own properties');
  }
});

var custom = Array.of.call(Custom, true);
assert.sameValue(custom[0], true, 'The value of custom[0] is expected to be true');

// ===== test/built-ins/Array/of/does-not-use-set-for-indices.js =====
// Copyright (C) 2020 Alexey Shvayka. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array.of
description: >
  Non-writable properties are overwritten by CreateDataProperty.
  (result object's "0" is non-writable)
info: |
  Array.of ( ...items )

  [...]
  7. Repeat, while k < len
    [...]
    c. Perform ? CreateDataPropertyOrThrow(A, Pk, kValue).
  [...]
includes: [propertyHelper.js]
---*/

var A = function(_length) {
  Object.defineProperty(this, "0", {
    value: 1,
    writable: false,
    enumerable: false,
    configurable: true,
  });
};

var res = Array.of.call(A, 2);

verifyProperty(res, "0", {
  value: 2,
  writable: true,
  enumerable: true,
  configurable: true,
});

// ===== test/built-ins/Array/of/length.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.of
description: >
  Array.of.length value and property descriptor
info: |
  Array.of ( ...items )

  The length property of the of function is 0.
includes: [propertyHelper.js]
---*/

verifyProperty(Array.of, "length", {
  value: 0,
  writable: false,
  enumerable: false,
  configurable: true
});

// ===== test/built-ins/Array/of/name.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.of
description: >
  Array.of.name value and property descriptor
info: |
  Array.of ( ...items )

  17 ECMAScript Standard Built-in Objects

includes: [propertyHelper.js]
---*/

verifyProperty(Array.of, "name", {
  value: "of",
  writable: false,
  enumerable: false,
  configurable: true
});

// ===== test/built-ins/Array/of/not-a-constructor.js =====
// Copyright (C) 2020 Rick Waldron. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-ecmascript-standard-built-in-objects
description: >
  Array.of does not implement [[Construct]], is not new-able
info: |
  ECMAScript Function Objects

  Built-in function objects that are not identified as constructors do not
  implement the [[Construct]] internal method unless otherwise specified in
  the description of a particular function.

  sec-evaluatenew

  ...
  7. If IsConstructor(constructor) is false, throw a TypeError exception.
  ...
includes: [isConstructor.js]
features: [Reflect.construct, arrow-function]
---*/

assert.sameValue(isConstructor(Array.of), false, 'isConstructor(Array.of) must return false');

assert.throws(TypeError, () => {
  new Array.of(1);
}, '`new Array.of(1)` throws a TypeError exception');


// ===== test/built-ins/Array/of/of.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.of
description: >
  Array.of property descriptor
info: |
  Array.of ( ...items )

  17 ECMAScript Standard Built-in Objects

includes: [propertyHelper.js]
---*/

verifyProperty(Array, "of", {
  writable: true,
  enumerable: false,
  configurable: true
});

// ===== test/built-ins/Array/of/proto-from-ctor-realm.js =====
// Copyright (C) 2016 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.of
description: Default [[Prototype]] value derived from realm of the constructor
info: |
    [...]
    4. If IsConstructor(C) is true, then
       a. Let A be ? Construct(C, « len »).
    [...]

    9.1.14 GetPrototypeFromConstructor

    [...]
    3. Let proto be ? Get(constructor, "prototype").
    4. If Type(proto) is not Object, then
       a. Let realm be ? GetFunctionRealm(constructor).
       b. Let proto be realm's intrinsic object named intrinsicDefaultProto.
    [...]
features: [cross-realm]
---*/

var other = $262.createRealm().global;
var C = new other.Function();
C.prototype = null;

var a = Array.of.call(C, 1, 2, 3);

assert.sameValue(
  Object.getPrototypeOf(a),
  other.Object.prototype,
  'Object.getPrototypeOf(Array.of.call(C, 1, 2, 3)) returns other.Object.prototype'
);

// ===== test/built-ins/Array/of/return-abrupt-from-contructor.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.of
description: >
  Return abrupt from this' constructor
info: |
  Array.of ( ...items )

  1. Let len be the actual number of arguments passed to this function.
  2. Let items be the List of arguments passed to this function.
  3. Let C be the this value.
  4. If IsConstructor(C) is true, then
    a. Let A be Construct(C, «len»).
  5. Else,
    b. Let A be ArrayCreate(len).
  6. ReturnIfAbrupt(A).
  ...
---*/

function T() {
  throw new Test262Error();
}

assert.throws(Test262Error, function() {
  Array.of.call(T);
}, 'Array.of.call(T) throws a Test262Error exception');

// ===== test/built-ins/Array/of/return-abrupt-from-data-property.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.of
description: >
  Return abrupt from Data Property creation
info: |
  Array.of ( ...items )

  ...
  7. Let k be 0.
  8. Repeat, while k < len
    a. Let kValue be items[k].
    b. Let Pk be ToString(k).
    c. Let defineStatus be CreateDataPropertyOrThrow(A,Pk, kValue).
    d. ReturnIfAbrupt(defineStatus).
  ...

  7.3.6 CreateDataPropertyOrThrow (O, P, V)

  ...
  3. Let success be CreateDataProperty(O, P, V).
  4. ReturnIfAbrupt(success).
  5. If success is false, throw a TypeError exception.
  ...
---*/

function T1() {
  Object.preventExtensions(this);
}

assert.throws(TypeError, function() {
  Array.of.call(T1, 'Bob');
}, 'Array.of.call(T1, "Bob") throws a TypeError exception');

function T2() {
  Object.defineProperty(this, 0, {
    configurable: false,
    writable: true,
    enumerable: true
  });
}

assert.throws(TypeError, function() {
  Array.of.call(T2, 'Bob');
}, 'Array.of.call(T2, "Bob") throws a TypeError exception')

// ===== test/built-ins/Array/of/return-abrupt-from-data-property-using-proxy.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.of
description: >
  Return abrupt from Data Property creation
info: |
  Array.of ( ...items )

  ...
  7. Let k be 0.
  8. Repeat, while k < len
    a. Let kValue be items[k].
    b. Let Pk be ToString(k).
    c. Let defineStatus be CreateDataPropertyOrThrow(A,Pk, kValue).
    d. ReturnIfAbrupt(defineStatus).
  ...

  7.3.6 CreateDataPropertyOrThrow (O, P, V)

  ...
  3. Let success be CreateDataProperty(O, P, V).
  4. ReturnIfAbrupt(success).
  ...
features: [Proxy]
---*/

function T() {
  return new Proxy({}, {
    defineProperty: function() {
      throw new Test262Error();
    }
  });
}

assert.throws(Test262Error, function() {
  Array.of.call(T, 'Bob');
}, 'Array.of.call(T, "Bob") throws a Test262Error exception');

// ===== test/built-ins/Array/of/return-abrupt-from-setting-length.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.of
description: >
  Return abrupt from setting the length property.
info: |
  Array.of ( ...items )

  ...
  9. Let setStatus be Set(A, "length", len, true).
  10. ReturnIfAbrupt(setStatus).
  ...
---*/

function T() {
  Object.defineProperty(this, 'length', {
    set: function() {
      throw new Test262Error();
    }
  });
}

assert.throws(Test262Error, function() {
  Array.of.call(T);
}, 'Array.of.call(T) throws a Test262Error exception');

// ===== test/built-ins/Array/of/return-a-custom-instance.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.of
description: >
  Returns an instance from a custom constructor.
info: |
  Array.of ( ...items )

  ...
  4. If IsConstructor(C) is true, then
    a. Let A be Construct(C, «len»).
  ...
  11. Return A.
---*/

function Coop() {}

var coop = Array.of.call(Coop, 'Mike', 'Rick', 'Leo');

assert.sameValue(
  coop.length, 3,
  'The value of coop.length is expected to be 3'
);
assert.sameValue(
  coop[0], 'Mike',
  'The value of coop[0] is expected to be "Mike"'
);
assert.sameValue(
  coop[1], 'Rick',
  'The value of coop[1] is expected to be "Rick"'
);
assert.sameValue(
  coop[2], 'Leo',
  'The value of coop[2] is expected to be "Leo"'
);
assert(coop instanceof Coop, 'The result of evaluating (coop instanceof Coop) is expected to be true');

// ===== test/built-ins/Array/of/return-a-new-array-object.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.of
description: >
  Returns a new Array.
info: |
  Array.of ( ...items )

  1. Let len be the actual number of arguments passed to this function.
  2. Let items be the List of arguments passed to this function.
  3. Let C be the this value.
  4. If IsConstructor(C) is true, then
    a. Let A be Construct(C, «len»).
  5. Else,
    b. Let A be ArrayCreate(len).
  ...
  11. Return A.
---*/

var result = Array.of();
assert(result instanceof Array, 'The result of evaluating (result instanceof Array) is expected to be true');

result = Array.of.call(undefined);
assert(
  result instanceof Array,
  'The result of evaluating (result instanceof Array) is expected to be true'
);

result = Array.of.call(Math.cos);
assert(
  result instanceof Array,
  'The result of evaluating (result instanceof Array) is expected to be true'
);

result = Array.of.call(Math.cos.bind(Math));
assert(
  result instanceof Array,
  'The result of evaluating (result instanceof Array) is expected to be true'
);

// ===== test/built-ins/Array/of/sets-length.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array.of
description: >
  Calls the length setter if available
info: |
  Array.of ( ...items )

  ...
  9. Let setStatus be Set(A, "length", len, true).
  ...
---*/

var hits = 0;
var value;
var _this_;

function Pack() {
  Object.defineProperty(this, "length", {
    set: function(len) {
      hits++;
      value = len;
      _this_ = this;
    }
  });
}

var result = Array.of.call(Pack, 'wolves', 'cards', 'cigarettes', 'lies');

assert.sameValue(hits, 1, 'The value of hits is expected to be 1');
assert.sameValue(
  value, 4,
  'The value of value is expected to be 4'
);
assert.sameValue(_this_, result, 'The value of _this_ is expected to equal the value of result');

// ===== test/built-ins/Array/prop-desc.js =====
// Copyright (C) 2019 Aleksey Shvayka. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-array-constructor
description: >
  Property descriptor of Array
info: |
  22.1.1 The Array Constructor

  * is the initial value of the Array property of the global object.

  17 ECMAScript Standard Built-in Objects

  Every other data property described in clauses 18 through 26 and in Annex B.2
  has the attributes { [[Writable]]: true, [[Enumerable]]: false,
  [[Configurable]]: true } unless otherwise specified.
includes: [propertyHelper.js]
---*/

verifyProperty(this, 'Array', {
  value: Array,
  writable: true,
  enumerable: false,
  configurable: true,
});

// ===== test/built-ins/Array/property-cast-boolean-primitive.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    A property name P (in the form of a string value) is an array index
    if and only if ToString(ToUint32(P)) is equal to P and ToUint32(P) is not equal to 2^32 - 1
es5id: 15.4_A1.1_T1
description: Checking for boolean primitive
---*/

var x = [];

x[true] = 1;
assert.sameValue(x[1], undefined, 'The value of x[1] is expected to equal undefined');
assert.sameValue(x["true"], 1, 'The value of x["true"] is expected to be 1');

x[false] = 0;
assert.sameValue(x[0], undefined, 'The value of x[0] is expected to equal undefined');
assert.sameValue(x["false"], 0, 'The value of x["false"] is expected to be 0')

// ===== test/built-ins/Array/property-cast-nan-infinity.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    A property name P (in the form of a string value) is an array index
    if and only if ToString(ToUint32(P)) is equal to P and ToUint32(P) is not equal to 2^32 - 1
es5id: 15.4_A1.1_T2
description: Checking for number primitive
---*/

var x = [];

x[NaN] = 1;
assert.sameValue(x[0], undefined, 'The value of x[0] is expected to equal undefined');
assert.sameValue(x["NaN"], 1, 'The value of x["NaN"] is expected to be 1');

var y = [];
y[Number.POSITIVE_INFINITY] = 1;
assert.sameValue(y[0], undefined, 'The value of y[0] is expected to equal undefined');
assert.sameValue(y["Infinity"], 1, 'The value of y["Infinity"] is expected to be 1');

var z = [];
z[Number.NEGATIVE_INFINITY] = 1;
assert.sameValue(z[0], undefined, 'The value of z[0] is expected to equal undefined');
assert.sameValue(z["-Infinity"], 1, 'The value of z["-Infinity"] is expected to be 1');

// ===== test/built-ins/Array/property-cast-number.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    A property name P (in the form of a string value) is an array index
    if and only if ToString(ToUint32(P)) is equal to P and ToUint32(P) is not equal to 2^32 - 1
es5id: 15.4_A1.1_T3
description: Checking for number primitive
---*/

var x = [];
x[4294967296] = 1;
assert.sameValue(x[0], undefined, 'The value of x[0] is expected to equal undefined');
assert.sameValue(x["4294967296"], 1, 'The value of x["4294967296"] is expected to be 1');

var y = [];
y[4294967297] = 1;
if (y[1] !== undefined) {
  throw new Test262Error('#3: y = []; y[4294967297] = 1; y[1] === undefined. Actual: ' + (y[1]));
}

//CHECK#4
if (y["4294967297"] !== 1) {
  throw new Test262Error('#4: y = []; y[4294967297] = 1; y["4294967297"] === 1. Actual: ' + (y["4294967297"]));
}

//CHECK#5
var z = [];
z[1.1] = 1;
if (z[1] !== undefined) {
  throw new Test262Error('#5: z = []; z[1.1] = 1; z[1] === undefined. Actual: ' + (z[1]));
}

//CHECK#6
if (z["1.1"] !== 1) {
  throw new Test262Error('#6: z = []; z[1.1] = 1; z["1.1"] === 1. Actual: ' + (z["1.1"]));
}

// ===== test/built-ins/Array/proto-from-ctor-realm-one.js =====
// Copyright (C) 2019 Alexey Shvayka. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-len
description: Default [[Prototype]] value derived from realm of the NewTarget.
info: |
  Array ( len )

  ...
  3. If NewTarget is undefined, let newTarget be the active function object; else let newTarget be NewTarget.
  4. Let proto be ? GetPrototypeFromConstructor(newTarget, "%Array.prototype%").
  5. Let array be ! ArrayCreate(0, proto).
  ...
  9. Return array.

  GetPrototypeFromConstructor ( constructor, intrinsicDefaultProto )

  ...
  3. Let proto be ? Get(constructor, "prototype").
  4. If Type(proto) is not Object, then
    a. Let realm be ? GetFunctionRealm(constructor).
    b. Set proto to realm's intrinsic object named intrinsicDefaultProto.
  5. Return proto.
features: [cross-realm, Reflect, Symbol]
---*/

var other = $262.createRealm().global;
var newTarget = new other.Function();
var arr;

newTarget.prototype = undefined;
arr = Reflect.construct(Array, [1], newTarget);
assert.sameValue(Object.getPrototypeOf(arr), other.Array.prototype, 'Object.getPrototypeOf(Reflect.construct(Array, [1], newTarget)) returns other.Array.prototype');

newTarget.prototype = null;
arr = Reflect.construct(Array, [1], newTarget);
assert.sameValue(Object.getPrototypeOf(arr), other.Array.prototype, 'Object.getPrototypeOf(Reflect.construct(Array, [1], newTarget)) returns other.Array.prototype');

newTarget.prototype = true;
arr = Reflect.construct(Array, [1], newTarget);
assert.sameValue(Object.getPrototypeOf(arr), other.Array.prototype, 'Object.getPrototypeOf(Reflect.construct(Array, [1], newTarget)) returns other.Array.prototype');

newTarget.prototype = '';
arr = Reflect.construct(Array, [1], newTarget);
assert.sameValue(Object.getPrototypeOf(arr), other.Array.prototype, 'Object.getPrototypeOf(Reflect.construct(Array, [1], newTarget)) returns other.Array.prototype');

newTarget.prototype = Symbol();
arr = Reflect.construct(Array, [1], newTarget);
assert.sameValue(Object.getPrototypeOf(arr), other.Array.prototype, 'Object.getPrototypeOf(Reflect.construct(Array, [1], newTarget)) returns other.Array.prototype');

newTarget.prototype = 0;
arr = Reflect.construct(Array, [1], newTarget);
assert.sameValue(Object.getPrototypeOf(arr), other.Array.prototype, 'Object.getPrototypeOf(Reflect.construct(Array, [1], newTarget)) returns other.Array.prototype');

// ===== test/built-ins/Array/proto-from-ctor-realm-two.js =====
// Copyright (C) 2019 Alexey Shvayka. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-items
description: Default [[Prototype]] value derived from realm of the NewTarget.
info: |
  Array ( ...items )

  ...
  3. If NewTarget is undefined, let newTarget be the active function object; else let newTarget be NewTarget.
  4. Let proto be ? GetPrototypeFromConstructor(newTarget, "%Array.prototype%").
  5. Let array be ? ArrayCreate(numberOfArgs, proto).
  ...
  10. Return array.

  GetPrototypeFromConstructor ( constructor, intrinsicDefaultProto )

  ...
  3. Let proto be ? Get(constructor, "prototype").
  4. If Type(proto) is not Object, then
    a. Let realm be ? GetFunctionRealm(constructor).
    b. Set proto to realm's intrinsic object named intrinsicDefaultProto.
  5. Return proto.
features: [cross-realm, Reflect, Symbol]
---*/

var other = $262.createRealm().global;
var newTarget = new other.Function();
var arr;

newTarget.prototype = undefined;
arr = Reflect.construct(Array, ['a', 'b'], newTarget);
assert.sameValue(Object.getPrototypeOf(arr), other.Array.prototype, 'Object.getPrototypeOf(Reflect.construct(Array, ["a", "b"], newTarget)) returns other.Array.prototype');

newTarget.prototype = null;
arr = Reflect.construct(Array, ['a', 'b'], newTarget);
assert.sameValue(Object.getPrototypeOf(arr), other.Array.prototype, 'Object.getPrototypeOf(Reflect.construct(Array, ["a", "b"], newTarget)) returns other.Array.prototype');

newTarget.prototype = false;
arr = Reflect.construct(Array, ['a', 'b'], newTarget);
assert.sameValue(Object.getPrototypeOf(arr), other.Array.prototype, 'Object.getPrototypeOf(Reflect.construct(Array, ["a", "b"], newTarget)) returns other.Array.prototype');

newTarget.prototype = '';
arr = Reflect.construct(Array, ['a', 'b'], newTarget);
assert.sameValue(Object.getPrototypeOf(arr), other.Array.prototype, 'Object.getPrototypeOf(Reflect.construct(Array, ["a", "b"], newTarget)) returns other.Array.prototype');

newTarget.prototype = Symbol();
arr = Reflect.construct(Array, ['a', 'b'], newTarget);
assert.sameValue(Object.getPrototypeOf(arr), other.Array.prototype, 'Object.getPrototypeOf(Reflect.construct(Array, ["a", "b"], newTarget)) returns other.Array.prototype');

newTarget.prototype = -1;
arr = Reflect.construct(Array, ['a', 'b'], newTarget);
assert.sameValue(Object.getPrototypeOf(arr), other.Array.prototype, 'Object.getPrototypeOf(Reflect.construct(Array, ["a", "b"], newTarget)) returns other.Array.prototype');

// ===== test/built-ins/Array/proto-from-ctor-realm-zero.js =====
// Copyright (C) 2016 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-array-constructor-array
description: Default [[Prototype]] value derived from realm of the NewTarget.
info: |
  Array ( )

  ...
  3. If NewTarget is undefined, let newTarget be the active function object; else let newTarget be NewTarget.
  4. Let proto be ? GetPrototypeFromConstructor(newTarget, "%Array.prototype%").
  5. Return ! ArrayCreate(0, proto).

  GetPrototypeFromConstructor ( constructor, intrinsicDefaultProto )

  ...
  3. Let proto be ? Get(constructor, "prototype").
  4. If Type(proto) is not Object, then
    a. Let realm be ? GetFunctionRealm(constructor).
    b. Set proto to realm's intrinsic object named intrinsicDefaultProto.
  5. Return proto.
features: [cross-realm, Reflect, Symbol]
---*/

var other = $262.createRealm().global;
var newTarget = new other.Function();
var arr;

newTarget.prototype = undefined;
arr = Reflect.construct(Array, [], newTarget);
assert.sameValue(Object.getPrototypeOf(arr), other.Array.prototype, 'Object.getPrototypeOf(Reflect.construct(Array, [], newTarget)) returns other.Array.prototype');

newTarget.prototype = null;
arr = Reflect.construct(Array, [], newTarget);
assert.sameValue(Object.getPrototypeOf(arr), other.Array.prototype, 'Object.getPrototypeOf(Reflect.construct(Array, [], newTarget)) returns other.Array.prototype');

newTarget.prototype = true;
arr = Reflect.construct(Array, [], newTarget);
assert.sameValue(Object.getPrototypeOf(arr), other.Array.prototype, 'Object.getPrototypeOf(Reflect.construct(Array, [], newTarget)) returns other.Array.prototype');

newTarget.prototype = 'str';
arr = Reflect.construct(Array, [], newTarget);
assert.sameValue(Object.getPrototypeOf(arr), other.Array.prototype, 'Object.getPrototypeOf(Reflect.construct(Array, [], newTarget)) returns other.Array.prototype');

newTarget.prototype = Symbol();
arr = Reflect.construct(Array, [], newTarget);
assert.sameValue(Object.getPrototypeOf(arr), other.Array.prototype, 'Object.getPrototypeOf(Reflect.construct(Array, [], newTarget)) returns other.Array.prototype');

newTarget.prototype = 1;
arr = Reflect.construct(Array, [], newTarget);
assert.sameValue(Object.getPrototypeOf(arr), other.Array.prototype, 'Object.getPrototypeOf(Reflect.construct(Array, [], newTarget)) returns other.Array.prototype');

// ===== test/built-ins/Array/proto.js =====
// Copyright (C) 2017 Leo Balter. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
esid: sec-properties-of-the-array-constructor
description: >
  The prototype of the Array constructor is the intrinsic object %FunctionPrototype%.
info: |
  22.1.2 Properties of the Array Constructor

  The value of the [[Prototype]] internal slot of the Array constructor is the
  intrinsic object %FunctionPrototype%.
---*/

assert.sameValue(
  Object.getPrototypeOf(Array),
  Function.prototype,
  'Object.getPrototypeOf(Array) returns Function.prototype'
);

// ===== test/built-ins/Array/S15.4.1_A1.1_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    The [[Prototype]] property of the newly constructed object
    is set to the original Array prototype object, the one that
    is the initial value of Array.prototype
es5id: 15.4.1_A1.1_T1
description: >
    Create new property of Array.prototype. When new Array object has
    this property
---*/

Array.prototype.myproperty = 42;
var x = Array();
assert.sameValue(x.myproperty, 42, 'The value of x.myproperty is expected to be 42');

assert.sameValue(
  Object.prototype.hasOwnProperty.call(x, 'myproperty'),
  false,
  'Object.prototype.hasOwnProperty.call(Array(), "myproperty") must return false'
);

// ===== test/built-ins/Array/S15.4.1_A1.1_T2.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    The [[Prototype]] property of the newly constructed object
    is set to the original Array prototype object, the one that
    is the initial value of Array.prototype
es5id: 15.4.1_A1.1_T2
description: Array.prototype.toString = Object.prototype.toString
---*/

Array.prototype.toString = Object.prototype.toString;
var x = Array();
assert.sameValue(x.toString(), "[object Array]", 'x.toString() must return "[object Array]"');

Array.prototype.toString = Object.prototype.toString;
var x = Array(0, 1, 2);
assert.sameValue(x.toString(), "[object Array]", 'x.toString() must return "[object Array]"');

// ===== test/built-ins/Array/S15.4.1_A1.1_T3.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    The [[Prototype]] property of the newly constructed object
    is set to the original Array prototype object, the one that
    is the initial value of Array.prototype
es5id: 15.4.1_A1.1_T3
description: Checking use isPrototypeOf
---*/

assert.sameValue(
  Array.prototype.isPrototypeOf(Array()),
  true,
  'Array.prototype.isPrototypeOf(Array()) must return true'
);

// ===== test/built-ins/Array/S15.4.1_A1.2_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: The [[Class]] property of the newly constructed object is set to "Array"
es5id: 15.4.1_A1.2_T1
description: Checking use Object.prototype.toString
---*/

var x = Array();
x.getClass = Object.prototype.toString;
assert.sameValue(x.getClass(), "[object Array]", 'x.getClass() must return "[object Array]"');

var x = Array(0, 1, 2);
x.getClass = Object.prototype.toString;
assert.sameValue(x.getClass(), "[object Array]", 'x.getClass() must return "[object Array]"');

// ===== test/built-ins/Array/S15.4.1_A1.3_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    This description of Array constructor applies if and only if
    the Array constructor is given no arguments or at least two arguments
es5id: 15.4.1_A1.3_T1
description: Checking case when Array constructor is given one argument
---*/

var x = Array(2);

assert.notSameValue(x.length, 1, 'The value of x.length is not 1');
assert.notSameValue(x[0], 2, 'The value of x[0] is not 2');

// ===== test/built-ins/Array/S15.4.1_A2.1_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    The length property of the newly constructed object;
    is set to the number of arguments
es5id: 15.4.1_A2.1_T1
description: Array constructor is given no arguments or at least two arguments
---*/
assert.sameValue(Array().length, 0, 'The value of Array().length is expected to be 0');
assert.sameValue(Array(0, 1, 0, 1).length, 4, 'The value of Array(0, 1, 0, 1).length is expected to be 4');

assert.sameValue(
  Array(undefined, undefined).length,
  2,
  'The value of Array(undefined, undefined).length is expected to be 2'
);

// ===== test/built-ins/Array/S15.4.1_A2.2_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    The 0 property of the newly constructed object is set to item0
    (if supplied); the 1 property of the newly constructed object is set to item1
    (if supplied); and, in general, for as many arguments as there are, the k property
    of the newly constructed object is set to argument k, where the first argument is
    considered to be argument number 0
es5id: 15.4.1_A2.2_T1
description: Checking correct work this algorithm
---*/

var x = Array(
  0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
  10, 11, 12, 13, 14, 15, 16, 17, 18, 19,
  20, 21, 22, 23, 24, 25, 26, 27, 28, 29,
  30, 31, 32, 33, 34, 35, 36, 37, 38, 39,
  40, 41, 42, 43, 44, 45, 46, 47, 48, 49,
  50, 51, 52, 53, 54, 55, 56, 57, 58, 59,
  60, 61, 62, 63, 64, 65, 66, 67, 68, 69,
  70, 71, 72, 73, 74, 75, 76, 77, 78, 79,
  80, 81, 82, 83, 84, 85, 86, 87, 88, 89,
  90, 91, 92, 93, 94, 95, 96, 97, 98, 99
);

for (var i = 0; i < 100; i++) {
  var result = true;
  if (x[i] !== i) {
    result = false;
  }
}

assert.sameValue(result, true, 'The value of result is expected to be true');

// ===== test/built-ins/Array/S15.4.1_A3.1_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    When Array is called as a function rather than as a constructor,
    it creates and initialises a new Array object
es5id: 15.4.1_A3.1_T1
description: Checking use typeof, instanceof
---*/

assert.sameValue(typeof Array(), "object", 'The value of `typeof Array()` is expected to be "object"');

assert.sameValue(
  Array() instanceof Array,
  true,
  'The result of evaluating (Array() instanceof Array) is expected to be true'
);

// ===== test/built-ins/Array/S15.4.2.1_A1.1_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    The [[Prototype]] property of the newly constructed object
    is set to the original Array prototype object, the one that
    is the initial value of Array.prototype
es5id: 15.4.2.1_A1.1_T1
description: >
    Create new property of Array.prototype. When new Array object has
    this property
---*/

Array.prototype.myproperty = 1;
var x = new Array();
assert.sameValue(x.myproperty, 1, 'The value of x.myproperty is expected to be 1');
assert.sameValue(x.hasOwnProperty('myproperty'), false, 'x.hasOwnProperty("myproperty") must return false');

// ===== test/built-ins/Array/S15.4.2.1_A1.1_T2.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    The [[Prototype]] property of the newly constructed object
    is set to the original Array prototype object, the one that
    is the initial value of Array.prototype
es5id: 15.4.2.1_A1.1_T2
description: Array.prototype.toString = Object.prototype.toString
---*/

Array.prototype.toString = Object.prototype.toString;
var x = new Array();
assert.sameValue(x.toString(), "[object Array]", 'x.toString() must return "[object Array]"');

Array.prototype.toString = Object.prototype.toString;
var x = new Array(0, 1, 2);
assert.sameValue(x.toString(), "[object Array]", 'x.toString() must return "[object Array]"');

// ===== test/built-ins/Array/S15.4.2.1_A1.1_T3.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    The [[Prototype]] property of the newly constructed object
    is set to the original Array prototype object, the one that
    is the initial value of Array.prototype
es5id: 15.4.2.1_A1.1_T3
description: Checking use isPrototypeOf
---*/
assert.sameValue(
  Array.prototype.isPrototypeOf(new Array()),
  true,
  'Array.prototype.isPrototypeOf(new Array()) must return true'
);

// ===== test/built-ins/Array/S15.4.2.1_A1.2_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: The [[Class]] property of the newly constructed object is set to "Array"
es5id: 15.4.2.1_A1.2_T1
description: Checking use Object.prototype.toString
---*/

var x = new Array();
x.getClass = Object.prototype.toString;
assert.sameValue(x.getClass(), "[object Array]", 'x.getClass() must return "[object Array]"');

var x = new Array(0, 1, 2);
x.getClass = Object.prototype.toString;
assert.sameValue(x.getClass(), "[object Array]", 'x.getClass() must return "[object Array]"');

// ===== test/built-ins/Array/S15.4.2.1_A1.3_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    This description of Array constructor applies if and only if
    the Array constructor is given no arguments or at least two arguments
es5id: 15.4.2.1_A1.3_T1
description: Checking case when Array constructor is given one argument
---*/

var x = new Array(2);

assert.notSameValue(x.length, 1, 'The value of x.length is not 1');
assert.notSameValue(x[0], 2, 'The value of x[0] is not 2');

// ===== test/built-ins/Array/S15.4.2.1_A2.1_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    The length property of the newly constructed object;
    is set to the number of arguments
es5id: 15.4.2.1_A2.1_T1
description: Array constructor is given no arguments or at least two arguments
---*/
assert.sameValue(new Array().length, 0, 'The value of new Array().length is expected to be 0');
assert.sameValue(new Array(0, 1, 0, 1).length, 4, 'The value of new Array(0, 1, 0, 1).length is expected to be 4');

assert.sameValue(
  new Array(undefined, undefined).length,
  2,
  'The value of new Array(undefined, undefined).length is expected to be 2'
);

// ===== test/built-ins/Array/S15.4.2.1_A2.2_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    The 0 property of the newly constructed object is set to item0
    (if supplied); the 1 property of the newly constructed object is set to item1
    (if supplied); and, in general, for as many arguments as there are, the k property
    of the newly constructed object is set to argument k, where the first argument is
    considered to be argument number 0
es5id: 15.4.2.1_A2.2_T1
description: Checking correct work this algorithm
---*/

var x = new Array(
  0, 1, 2, 3, 4, 5, 6, 7, 8, 9,
  10, 11, 12, 13, 14, 15, 16, 17, 18, 19,
  20, 21, 22, 23, 24, 25, 26, 27, 28, 29,
  30, 31, 32, 33, 34, 35, 36, 37, 38, 39,
  40, 41, 42, 43, 44, 45, 46, 47, 48, 49,
  50, 51, 52, 53, 54, 55, 56, 57, 58, 59,
  60, 61, 62, 63, 64, 65, 66, 67, 68, 69,
  70, 71, 72, 73, 74, 75, 76, 77, 78, 79,
  80, 81, 82, 83, 84, 85, 86, 87, 88, 89,
  90, 91, 92, 93, 94, 95, 96, 97, 98, 99
);

for (var i = 0; i < 100; i++) {
  var result = true;
  if (x[i] !== i) {
    result = false;
  }
}

assert.sameValue(result, true, 'The value of result is expected to be true');

// ===== test/built-ins/Array/S15.4.3_A1.1_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    The value of the internal [[Prototype]] property of
    the Array constructor is the Function prototype object
es5id: 15.4.3_A1.1_T1
description: >
    Create new property of Function.prototype. When Array constructor
    has this property
---*/

Function.prototype.myproperty = 1;

assert.sameValue(Array.myproperty, 1, 'The value of Array.myproperty is expected to be 1');
assert.sameValue(Array.hasOwnProperty('myproperty'), false, 'Array.hasOwnProperty("myproperty") must return false');

// ===== test/built-ins/Array/S15.4.3_A1.1_T2.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    The value of the internal [[Prototype]] property of
    the Array constructor is the Function prototype object
es5id: 15.4.3_A1.1_T2
description: Function.prototype.toString = Object.prototype.toString
---*/

Function.prototype.toString = Object.prototype.toString;

assert.sameValue(
  Array.toString(),
  "[object Function]",
  'Array.toString() must return "[object Function]"'
);

// ===== test/built-ins/Array/S15.4.3_A1.1_T3.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    The value of the internal [[Prototype]] property of
    the Array constructor is the Function prototype object
es5id: 15.4.3_A1.1_T3
description: Checking use isPrototypeOf
---*/
assert.sameValue(
  Function.prototype.isPrototypeOf(Array),
  true,
  'Function.prototype.isPrototypeOf(Array) must return true'
);

// ===== test/built-ins/Array/S15.4.5.1_A1.2_T2.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    For every integer k that is less than the value of
    the length property of A but not less than ToUint32(length),
    if A itself has a property (not an inherited property) named ToString(k),
    then delete that property
es5id: 15.4.5.1_A1.2_T2
description: Checking an inherited property
---*/

Array.prototype[2] = -1;
var x = [0, 1, 2];
assert.sameValue(x[2], 2, 'The value of x[2] is expected to be 2');

x.length = 2;
assert.sameValue(x[2], -1, 'The value of x[2] is expected to be -1');

// ===== test/built-ins/Array/S15.4.5.1_A2.1_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    If P is not an array index, return
    (Create a property with name P, set its value to V and give it empty attributes)
es5id: 15.4.5.1_A2.1_T1
description: P in [4294967295, -1, true]
---*/

var x = [];
x[4294967295] = 1;
assert.sameValue(x.length, 0, 'The value of x.length is expected to be 0');
assert.sameValue(x[4294967295], 1, 'The value of x[4294967295] is expected to be 1');

x = [];
x[-1] = 1;
assert.sameValue(x.length, 0, 'The value of x.length is expected to be 0');
assert.sameValue(x[-1], 1, 'The value of x[-1] is expected to be 1');

x = [];
x[true] = 1;
assert.sameValue(x.length, 0, 'The value of x.length is expected to be 0');
assert.sameValue(x[true], 1, 'The value of x[true] is expected to be 1');

// ===== test/built-ins/Array/S15.4.5.1_A2.2_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    If ToUint32(P) is less than the value of
    the length property of A, then return
es5id: 15.4.5.1_A2.2_T1
description: length === 100, P in [0, 98, 99]
---*/

var x = Array(100);
x[0] = 1;
assert.sameValue(x.length, 100, 'The value of x.length is expected to be 100');

x[98] = 1;
assert.sameValue(x.length, 100, 'The value of x.length is expected to be 100');

x[99] = 1;
assert.sameValue(x.length, 100, 'The value of x.length is expected to be 100');

// ===== test/built-ins/Array/S15.4.5.1_A2.3_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    If ToUint32(P) is less than the value of
    the length property of A, change (or set) length to ToUint32(P)+1
es5id: 15.4.5.1_A2.3_T1
description: length = 100, P in [100, 199]
---*/

var x = Array(100);
x[100] = 1;
assert.sameValue(x.length, 101, 'The value of x.length is expected to be 101');

x[199] = 1;
assert.sameValue(x.length, 200, 'The value of x.length is expected to be 200');

// ===== test/built-ins/Array/S15.4.5.2_A1_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    Every Array object has a length property whose value is
    always a nonnegative integer less than 2^32. The value of the length property is
    numerically greater than the name of every property whose name is an array index
es5id: 15.4.5.2_A1_T1
description: Checking boundary points
---*/

var x = [];
assert.sameValue(x.length, 0, 'The value of x.length is expected to be 0');

x[0] = 1;
assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');

x[1] = 1;
assert.sameValue(x.length, 2, 'The value of x.length is expected to be 2');

x[2147483648] = 1;
assert.sameValue(x.length, 2147483649, 'The value of x.length is expected to be 2147483649');

x[4294967294] = 1;
assert.sameValue(x.length, 4294967295, 'The value of x.length is expected to be 4294967295');

// ===== test/built-ins/Array/S15.4.5.2_A1_T2.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    Every Array object has a length property whose value is
    always a nonnegative integer less than 2^32. The value of the length property is
    numerically greater than the name of every property whose name is an array index
es5id: 15.4.5.2_A1_T2
description: P = "2^32 - 1" is not index array
---*/

var x = [];
x[4294967295] = 1;
assert.sameValue(x.length, 0, 'The value of x.length is expected to be 0');

var y = [];
y[1] = 1;
y[4294967295] = 1;
assert.sameValue(y.length, 2, 'The value of y.length is expected to be 2');

// ===== test/built-ins/Array/S15.4.5.2_A2_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    If a property is added whose name is an array index,
    the length property is changed
es5id: 15.4.5.2_A2_T1
description: Checking length property
---*/

var x = [];
assert.sameValue(x.length, 0, 'The value of x.length is expected to be 0');

x[0] = 1;
assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');

x[1] = 1;
assert.sameValue(x.length, 2, 'The value of x.length is expected to be 2');

x[9] = 1;
assert.sameValue(x.length, 10, 'The value of x.length is expected to be 10');

// ===== test/built-ins/Array/S15.4.5.2_A3_T1.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    If the length property is changed, every property whose name
    is an array index whose value is not smaller than the new length is automatically deleted
es5id: 15.4.5.2_A3_T1
description: >
    If new length greater than the name of every property whose name
    is an array index
---*/

var x = [];
x.length = 1;
assert.sameValue(x.length, 1, 'The value of x.length is expected to be 1');

x[5] = 1;
x.length = 10;
assert.sameValue(x.length, 10, 'The value of x.length is expected to be 10');
assert.sameValue(x[5], 1, 'The value of x[5] is expected to be 1');

// ===== test/built-ins/Array/S15.4.5.2_A3_T2.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    If the length property is changed, every property whose name
    is an array index whose value is not smaller than the new length is automatically deleted
es5id: 15.4.5.2_A3_T2
description: >
    If new length greater than the name of every property whose name
    is an array index
---*/

var x = [];
x[1] = 1;
x[3] = 3;
x[5] = 5;
x.length = 4;
assert.sameValue(x.length, 4, 'The value of x.length is expected to be 4');
assert.sameValue(x[5], undefined, 'The value of x[5] is expected to equal undefined');
assert.sameValue(x[3], 3, 'The value of x[3] is expected to be 3');

x.length = new Number(6);
assert.sameValue(x[5], undefined, 'The value of x[5] is expected to equal undefined');

x.length = 0;
assert.sameValue(x[0], undefined, 'The value of x[0] is expected to equal undefined');

x.length = 1;
assert.sameValue(x[1], undefined, 'The value of x[1] is expected to equal undefined');

// ===== test/built-ins/Array/S15.4.5.2_A3_T3.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    If the length property is changed, every property whose name
    is an array index whose value is not smaller than the new length is automatically deleted
es5id: 15.4.5.2_A3_T3
description: "[[Put]] (length, 4294967296)"
---*/

var x = [];
x.length = 4294967295;
assert.sameValue(x.length, 4294967295, 'The value of x.length is expected to be 4294967295');

try {
  x = [];
  x.length = 4294967296;
  throw new Test262Error('#2.1: x = []; x.length = 4294967296 throw RangeError. Actual: x.length === ' + (x.length));
} catch (e) {
  assert.sameValue(
    e instanceof RangeError,
    true,
    'The result of evaluating (e instanceof RangeError) is expected to be true'
  );
}

// ===== test/built-ins/Array/S15.4_A1.1_T10.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    A property name P (in the form of a string value) is an array index
    if and only if ToString(ToUint32(P)) is equal to P and ToUint32(P) is not equal to 2^32 - 1
es5id: 15.4_A1.1_T10
description: Array index is power of two
---*/

var x = [];
var k = 1;
for (var i = 0; i < 32; i++) {
  k = k * 2;
  x[k - 2] = k;
}

k = 1;
for (i = 0; i < 32; i++) {
  k = k * 2;
  assert.sameValue(x[k - 2], k, 'The value of x[k - 2] is expected to equal the value of k');
}

// ===== test/built-ins/Array/S15.4_A1.1_T4.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    A property name P (in the form of a string value) is an array index
    if and only if ToString(ToUint32(P)) is equal to P and ToUint32(P) is not equal to 2^32 - 1
es5id: 15.4_A1.1_T4
description: Checking for string primitive
---*/

var x = [];
x["0"] = 0;
assert.sameValue(x[0], 0, 'The value of x[0] is expected to be 0');

var y = [];
y["1"] = 1;
assert.sameValue(y[1], 1, 'The value of y[1] is expected to be 1');

// ===== test/built-ins/Array/S15.4_A1.1_T5.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    A property name P (in the form of a string value) is an array index
    if and only if ToString(ToUint32(P)) is equal to P and ToUint32(P) is not equal to 2^32 - 1
es5id: 15.4_A1.1_T5
description: Checking for null and undefined
---*/

var x = [];
x[null] = 0;
assert.sameValue(x[0], undefined, 'The value of x[0] is expected to equal undefined');
assert.sameValue(x["null"], 0, 'The value of x["null"] is expected to be 0');

var y = [];
y[undefined] = 0;
assert.sameValue(y[0], undefined, 'The value of y[0] is expected to equal undefined');
assert.sameValue(y["undefined"], 0, 'The value of y["undefined"] is expected to be 0');

// ===== test/built-ins/Array/S15.4_A1.1_T6.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    A property name P (in the form of a string value) is an array index
    if and only if ToString(ToUint32(P)) is equal to P and ToUint32(P) is not equal to 2^32 - 1
es5id: 15.4_A1.1_T6
description: Checking for Boolean object
---*/

var x = [];
x[new Boolean(true)] = 1;
assert.sameValue(x[1], undefined, 'The value of x[1] is expected to equal undefined');
assert.sameValue(x["true"], 1, 'The value of x["true"] is expected to be 1');

x[new Boolean(false)] = 0;
assert.sameValue(x[0], undefined, 'The value of x[0] is expected to equal undefined');
assert.sameValue(x["false"], 0, 'The value of x["false"] is expected to be 0');

// ===== test/built-ins/Array/S15.4_A1.1_T7.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    A property name P (in the form of a string value) is an array index
    if and only if ToString(ToUint32(P)) is equal to P and ToUint32(P) is not equal to 2^32 - 1
es5id: 15.4_A1.1_T7
description: Checking for Number object
---*/

var x = [];
x[new Number(0)] = 0;
assert.sameValue(x[0], 0, 'The value of x[0] is expected to be 0');

var y = [];
y[new Number(1)] = 1;
assert.sameValue(y[1], 1, 'The value of y[1] is expected to be 1');

var z = [];
z[new Number(1.1)] = 1;
assert.sameValue(z["1.1"], 1, 'The value of z["1.1"] is expected to be 1');

// ===== test/built-ins/Array/S15.4_A1.1_T8.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    A property name P (in the form of a string value) is an array index
    if and only if ToString(ToUint32(P)) is equal to P and ToUint32(P) is not equal to 2^32 - 1
es5id: 15.4_A1.1_T8
description: Checking for Number object
---*/

var x = [];
x[new String("0")] = 0;
assert.sameValue(x[0], 0, 'The value of x[0] is expected to be 0');

var y = [];
y[new String("1")] = 1;
assert.sameValue(y[1], 1, 'The value of y[1] is expected to be 1');

var z = [];
z[new String("1.1")] = 1;
assert.sameValue(z["1.1"], 1, 'The value of z["1.1"] is expected to be 1');

// ===== test/built-ins/Array/S15.4_A1.1_T9.js =====
// Copyright 2009 the Sputnik authors.  All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
info: |
    A property name P (in the form of a string value) is an array index
    if and only if ToString(ToUint32(P)) is equal to P and ToUint32(P) is not equal to 2^32 - 1
es5id: 15.4_A1.1_T9
description: If Type(value) is Object, evaluate ToPrimitive(value, String)
---*/

var x = [];
var object = {
  valueOf: function() {
    return 1
  }
};
x[object] = 0;
assert.sameValue(x["[object Object]"], 0, 'The value of x["[object Object]"] is expected to be 0');

x = [];
var object = {
  valueOf: function() {
    return 1
  },
  toString: function() {
    return 0
  }
};
x[object] = 0;
assert.sameValue(x[0], 0, 'The value of x[0] is expected to be 0');

x = [];
var object = {
  valueOf: function() {
    return 1
  },
  toString: function() {
    return {}
  }
};
x[object] = 0;
assert.sameValue(x[1], 0, 'The value of x[1] is expected to be 0');

try {
  x = [];
  var object = {
    valueOf: function() {
      throw "error"
    },
    toString: function() {
      return 1
    }
  };
  x[object] = 0;
  assert.sameValue(x[1], 0, 'The value of x[1] is expected to be 0');
}
catch (e) {
  assert.notSameValue(e, "error", 'The value of e is not "error"');
}

x = [];
var object = {
  toString: function() {
    return 1
  }
};
x[object] = 0;
assert.sameValue(x[1], 0, 'The value of x[1] is expected to be 0');

x = [];
var object = {
  valueOf: function() {
    return {}
  },
  toString: function() {
    return 1
  }
}
x[object] = 0;
assert.sameValue(x[1], 0, 'The value of x[1] is expected to be 0');

try {
  x = [];
  var object = {
    valueOf: function() {
      return 1
    },
    toString: function() {
      throw "error"
    }
  };
  x[object];
  throw new Test262Error('#7.1: x = []; var object = {valueOf: function() {return 1}, toString: function() {throw "error"}}; x[object] throw "error". Actual: ' + (x[object]));
}
catch (e) {
  assert.sameValue(e, "error", 'The value of e is expected to be "error"');
}

try {
  x = [];
  var object = {
    valueOf: function() {
      return {}
    },
    toString: function() {
      return {}
    }
  };
  x[object];
  throw new Test262Error('#8.1: x = []; var object = {valueOf: function() {return {}}, toString: function() {return {}}}; x[object] throw TypeError. Actual: ' + (x[object]));
}
catch (e) {
  assert.sameValue(
    e instanceof TypeError,
    true,
    'The result of evaluating (e instanceof TypeError) is expected to be true'
  );
}

// ===== test/built-ins/Array/Symbol.species/length.js =====
// Copyright (C) 2015 André Bargull. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.

/*---
es6id: 22.1.2.5
description: >
  get Array [ @@species ].length is 0.
info: |
  get Array [ @@species ]

  17 ECMAScript Standard Built-in Objects:
    Every built-in Function object, including constructors, has a length
    property whose value is an integer. Unless otherwise specified, this
    value is equal to the largest number of named arguments shown in the
    subclause headings for the function description, including optional
    parameters. However, rest parameters shown using the form “...name”
    are not included in the default argument count.

    Unless otherwise specified, the length property of a built-in Function
    object has the attributes { [[Writable]]: false, [[Enumerable]]: false,
    [[Configurable]]: true }.
includes: [propertyHelper.js]
features: [Symbol.species]
---*/

var desc = Object.getOwnPropertyDescriptor(Array, Symbol.species);

verifyProperty(desc.get, "length", {
  value: 0,
  writable: false,
  enumerable: false,
  configurable: true
});

// ===== test/built-ins/Array/Symbol.species/return-value.js =====
// Copyright (C) 2016 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
esid: sec-get-array-@@species
description: Return value of @@species accessor method
info: |
    1. Return the this value.
features: [Symbol.species]
---*/

var thisVal = {};
var accessor = Object.getOwnPropertyDescriptor(Array, Symbol.species).get;

assert.sameValue(accessor.call(thisVal), thisVal);

// ===== test/built-ins/Array/Symbol.species/symbol-species.js =====
// Copyright 2015 Cubane Canada, Inc.  All rights reserved.
// See LICENSE for details.

/*---
info: |
 Array has a property at `Symbol.species`
esid: sec-get-array-@@species
author: Sam Mikes
description: Array[Symbol.species] exists per spec
includes: [propertyHelper.js]
features: [Symbol.species]
---*/

var desc = Object.getOwnPropertyDescriptor(Array, Symbol.species);

assert.sameValue(desc.set, undefined);
assert.sameValue(typeof desc.get, 'function');

verifyNotWritable(Array, Symbol.species, Symbol.species);
verifyNotEnumerable(Array, Symbol.species);
verifyConfigurable(Array, Symbol.species);

// ===== test/built-ins/Array/Symbol.species/symbol-species-name.js =====
// Copyright (C) 2015 the V8 project authors. All rights reserved.
// This code is governed by the BSD license found in the LICENSE file.
/*---
es6id: 22.1.2.5
description: >
  Array[Symbol.species] accessor property get name
info: |
  22.1.2.5 get Array [ @@species ]

  ...
  The value of the name property of this function is "get [Symbol.species]".
features: [Symbol.species]
includes: [propertyHelper.js]
---*/

var descriptor = Object.getOwnPropertyDescriptor(Array, Symbol.species);

verifyProperty(descriptor.get, "name", {
  value: "get [Symbol.species]",
  writable: false,
  enumerable: false,
  configurable: true
});
