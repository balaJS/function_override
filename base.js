// var root_level = {	//define some function inside of the object.
// 	function_one: function() {
// 		return 'function_one';
// 	},
// 	function_two: function() {
// 		return 'function_two';
// 	},
// 	function_three: function() {
// 		return 'function_three';
// 	},
// };

function singleton() {
	return 'singleton';
}

$(function(){
	//var output = root_level.function_two(); //here method call happened
	var output = singleton();
	$('#output').html(output);
});

