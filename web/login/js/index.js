/* ------------------------------------ Click on login and Sign Up to  changue and view the effect
---------------------------------------
*/

function cambiar_login() {
  document.querySelector('.cont_forms').className = "cont_forms cont_forms_active_foro";  
document.querySelector('.cont_form_foro').style.display = "block";
document.querySelector('.cont_form_ig').style.opacity = "0";               

setTimeout(function(){  document.querySelector('.cont_form_foro').style.opacity = "1"; },400);  
  
setTimeout(function(){    
document.querySelector('.cont_form_ig').style.display = "none";
},200);  
  }

function cambiar_sign_up(at) {
  document.querySelector('.cont_forms').className = "cont_forms cont_forms_active_ig";
  document.querySelector('.cont_form_ig').style.display = "block";
document.querySelector('.cont_form_foro').style.opacity = "0";
  
setTimeout(function(){  document.querySelector('.cont_form_ig').style.opacity = "1";
},100);  

setTimeout(function(){   document.querySelector('.cont_form_foro').style.display = "none";
},400);  


}    



function ocultar_login_sign_up() {

document.querySelector('.cont_forms').className = "cont_forms";  
document.querySelector('.cont_form_ig').style.opacity = "0";               
document.querySelector('.cont_form_foro').style.opacity = "0"; 

setTimeout(function(){
document.querySelector('.cont_form_ig').style.display = "none";
document.querySelector('.cont_form_foro').style.display = "none";
},500);  
  
  }