const form = document.querySelector('form');
const btn = document.querySelector('buttom');

form.onsubmit = (e)=>{
    e.preventDefault();
}

btn.onclick = ()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/signin.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
              let data = xhr.response;
              if(data === "success"){
                
              }else{
                alert(`Error: ${data}`);
              }
          }
      }
    }
    let formData = new FormData(form);
    xhr.send(formData);
}