/*
Author by: Mark Taylor
Created: 07/10/2012
Last updated: 30/04/2013

Revision history: 
07/10/2012 - Initial creation.
08/10/2012 - Slightly optimized.
28/01/2013 - Changed the script so it no longer uses <body onload='sparkline()'>. Now uses the jQuery style syntax $(function(){......});
30/04/2013 - Added code to insert a CSS class to better highlight applications that have the 'Follow up' flag set.

Description: Performs a number of functions.  The primary funcrtion is to draw a 'sparkline'-like graph at the top of the summary page, showing the number of job applications per week over the previous 4 weeks.

Guidence on Canvas at:
http://developer.apple.com/library/safari/#documentation/AudioVideo/Conceptual/HTML-canvas-guide/Introduction/Introduction.html#//apple_ref/doc/uid/TP40010542-CH1-SW1
*/

$(function(){

var red		= "rgba(255,  70,  50, 0.9)";
var green 	= "rgba( 120,255, 130, 0.9)";
var blue 	= "rgba( 50,  50, 255, 0.9)";
var purple 	= "rgba(160,  70, 220, 0.9)";
var yellow 	= "rgba(255, 255,   0, 0.9)";
var orange 	= "rgba(255, 120,  70, 0.9)";

var palette = [red, yellow, orange, green, purple];

/* Number of weeks is one less than is required, because the 'colheights' array is zero indexed. */
var weeks = 4;
var colwidth = 20;
var colgap = 8;
var height = $("#sparkline").innerHeight();
var width  = $("#sparkline").innerWidth();
var colheights = [];
var canvas = document.getElementById("sparkline");

/* Get the data for the chart from the <div> with the ID 'appdata' and place it the array 'colheights'. Data in the form data-week0='20'. */
for(var w = 0; w <= weeks; w++){
	colheights[w] = $("#appdata").data("week"+w);
}

/*
Calculate a scaling factor so the largest value is just a bit smaller than the height of the canvas.
1. Find the biggest value.
2. Calculate a margin so even the biggest value is not 100% of the canvas size.
3. Calculate the scale factor.
*/
var largest = Math.max.apply(Math, colheights);
var margin = height / 10;
var scale = (height - margin) / largest;

if(canvas.getContext){
	var canvas = canvas.getContext("2d");

	/* Create background gradient. */
	var lingrad = canvas.createLinearGradient(0, 0, 0, height);
	lingrad.addColorStop(0.0, '#fff');
	lingrad.addColorStop(1.0, '#888');
	canvas.fillStyle = lingrad;
	canvas.fillRect(0, 0, width, height);
	
		for(var i = 0; i <= weeks; i++){
			canvas.fillStyle = palette[i];
			canvas.fillRect((colwidth + colgap) * i, height - (colheights[i]*scale), colwidth, colheights[i] * scale);
		}
	}
	
	/* Adds another class to the table cells that contain the word 'Yes'. */
	$("td:contains('Yes')").addClass("chase");
}
) /* End of the function that becomes active when the page (DOM) is ready. */


/* A function used on the summary page (index.php) to hide columns in the table. Called when a table column header <th> is clicked on. */
function col_hide(col_name){
	var duration = 1000;
	$('td:nth-child('+col_name+'),th:nth-child('+col_name+')').fadeOut(duration);
}