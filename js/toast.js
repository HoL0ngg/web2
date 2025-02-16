function showToast(message,type){
    let toast = document.getElementById("toast");        
    toast.innerText = message;    
    toast.style.backgroundColor = type == 'success' ? 'rgba(0, 255, 0, 0.5)' : ' rgba(255, 0, 0, 0.7)';
    toast.style.display = 'block';
    // if(type === 'error'){
    //     toast.style.backgroundColor = 'rgba(255, 0, 0, 0.7)';
    //     toast.style.display = 'block';
    // }
    // else if(type === 'success'){
    //     // toast.style.backgroundColor = '#47d864';
    //     toast.style.backgroundColor = 'rgba(0, 255, 0, 0.5)';
    //     toast.style.display = 'block';
    // }
    setTimeout(() => {
        toast.style.display = 'none';
    }, 3000);
}