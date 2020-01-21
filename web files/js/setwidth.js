/*
Author by: Mark Taylor
Created: 07/03/2014
Last updated: 07/03/2014

Revision history: 
07/03/2014 - Initial creation.

Description: Sets the width of cells to the width of the text within the cell.
*/

$(function(){
/* First cell in the cells section */
var cellwidth1 = $("tr[name='cellcells'] td:nth-child(1) input").width();
console.log("Cell 1 width = " + cellwidth1);
cellwidth1 = cellwidth1 * 0.7;
$("tr[name='cellcells'] td:nth-child(1) input").width(cellwidth1);
console.log("Cell 1 width now = " + cellwidth1);

/* Second cell in the cells section */
var cellwidth2 = $("tr[name='cellcells'] td:nth-child(2) input").width();
console.log("Cell 2 width = " + cellwidth2);
cellwidth2 = cellwidth2 * 0.7;
$("tr[name='cellcells'] td:nth-child(2) input").width(cellwidth2);
console.log("Cell 2 width now = " + cellwidth2);

/* Third cell in the cells section */
var cellwidth3 = $("tr[name='cellcells'] td:nth-child(3) input").width();
console.log("Cell 3 width = " + cellwidth3);
cellwidth3 = cellwidth3 * 0.7;
$("tr[name='cellcells'] td:nth-child(3) input").width(cellwidth3);
console.log("Cell 3 width now = " + cellwidth3);
})