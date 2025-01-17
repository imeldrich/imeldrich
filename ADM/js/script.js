let userBox = document.querySelector('.header .flex .account-box');

document.querySelector('#user-btn').onclick = () =>{
    userBox.classList.toggle('active');
}

window.onscroll = () =>{
    userBox.classList.remove('active');
}


// quantity input
function quantity(input){
    if(input.value.length > 3){
    input.value = input.value.slice(0, 3);
}
}

// contact number input
function contact(input){
    if(input.value.length > 11){
    input.value = input.value.slice(0, 11);
}
}

// postal input
function limitInput(input){
    const value = input.value.toString();
    if (value.length > 4) {
        input.value = value.slice(0, 4);
    }
}
