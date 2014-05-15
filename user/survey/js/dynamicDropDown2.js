<!-- Paste this code into an external JavaScript file named: dynamicDropDown2  -->

/* This script and many more are available free online at
The JavaScript Source :: http://javascript.internet.com
Created by: Jay M. Rumsey, OD :: http://www.nova.edu/~rumsey
 */

 function NewList(selObj,newObj) {
 var selElem = document.getElementById(selObj);
 var selIndex = selElem.selectedIndex;
 var newElem = document.getElementById(newObj);
 var tmp = '';
 var tmp2 = '';
 newElem.options.length = 0;
 for (var i=0; i<selElem.options.length; i++) {
   tmp = selElem.options[i].value;
   tmp2 = selElem.options[i].text;
   if (i != selIndex) { newElem.options[newElem.options.length] = new Option(tmp,tmp2); }
 }
}


 function NewListOther(selObj,newObj,other) {
 document.getElementById(selObj).focus();
 var selElem = document.getElementById(selObj);
 var selIndex = selElem.selectedIndex;
 var newElem = document.getElementById(newObj);
 var tmp = '';
 var tmp2 = '';
 newElem.options.length = 0;
 for (var i=0; i<selElem.options.length; i++) {
   tmp = selElem.options[i].value;
   tmp2 = selElem.options[i].text;
   if (i != selIndex) { newElem.options[newElem.options.length] = new Option(tmp,tmp2); }
 }
 if(selIndex == selElem.options.length-1){
   document.getElementById(other).style.display = '';
   document.getElementById(other).focus();
  }else{
   document.getElementById(other).style.display = 'none';
  }
}


 function ShowField1(selObj,other) {
 document.getElementById(selObj).focus();
 var selElem = document.getElementById(selObj);
 var selIndex = selElem.selectedIndex;
 if(selIndex == selElem.options.length-1){
   document.getElementById(other).style.display = '';
   document.getElementById(other).focus();
  }else{
   document.getElementById(other).style.display = 'none';
  }

}
