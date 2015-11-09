 document.addEventListener("DOMContentLoaded", function() {
    NodeList.prototype.forEach = Array.prototype.forEach;
 	var searchBox = document.querySelector('.search-box');
    searchBox.addEventListener('input', function(){
    	var productIds = document.querySelectorAll('#data li');
        productIds.forEach(function(element){
    		if(!element.id.match(searchBox.value)) {
    			element.style.display = "none";
    			element.className = "hidden";
    		} else {
    			element.style.display = "block";
    			element.className = "data-container visible";
    		}
        })
        var flag = true;
        var visible = document.querySelectorAll('.visible');
        visible.forEach(function(element){
            if(flag) {
                element.className = element.className.replace('light') + " dark";
                flag = !flag;
            } else {
                element.className = element.className.replace('dark') + " light";
                flag = !flag;
            }
        })
    })
  });