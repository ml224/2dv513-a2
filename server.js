"use strict";

const fs = require('fs');
const readline = require('readline2');
const bz2 = require('unbzip2-stream');

//creating line-by-line interface for data in bz2
let lr = readline.createInterface({
    input: fs.createReadStream('./data.bz2').pipe(bz2())
});

let nr = 0;
lr.on("line", (line) => {
    nr+=1;
    console.log(line.name);
    if(nr >= 2) {
        lr.close();
    }
});



