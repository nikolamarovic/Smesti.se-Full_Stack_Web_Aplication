const stars4 = document.querySelector(".ratings4").children;
const ljubaznost = document.querySelector("#ljubaznost");
let index4;

for(let i=0;i<stars4.length;i++){
    stars4[i].addEventListener("mouseover",function(){
        for(let j=0;j<stars4.length;j++){
            stars4[j].classList.remove("fa-star");
            stars4[j].classList.add("fa-star-o");
        }
        for(let j=0;j<=i;j++){
            stars4[j].classList.remove("fa-star-o");
            stars4[j].classList.add("fa-star");
        }
    });
    stars4[i].addEventListener("click",function(){
        index4=i;
        ljubaznost.value = index4 + 1;
    });
    stars4[i].addEventListener("mouseout",function(){
        for(let j=0;j<stars4.length;j++){
            stars4[j].classList.remove("fa-star");
            stars4[j].classList.add("fa-star-o");
        }
        for(let j=0;j<=index4;j++){
            stars4[j].classList.remove("fa-star-o");
            stars4[j].classList.add("fa-star");
        }
    });
}