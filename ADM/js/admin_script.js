let userBox = document.querySelector('.header .flex .account-box');

document.querySelector('#user-btn').onclick = () =>{
   userBox.classList.toggle('active'); 
}

window.onscroll = () =>{
   userBox.classList.remove('active');
}