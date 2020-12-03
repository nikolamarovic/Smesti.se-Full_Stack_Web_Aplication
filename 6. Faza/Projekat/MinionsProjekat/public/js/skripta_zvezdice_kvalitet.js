const stars2 = document.querySelector(".ratings2").children;
const kvalitet = document.querySelector("#kvalitet");
let index2;

for(let i=0;i<stars2.length;i++){
    stars2[i].addEventListener("mouseover",function(){
        for(let j=0;j<stars2.length;j++){
            stars2[j].classList.remove("fa-star");
            stars2[j].classList.add("fa-star-o");
        }
        for(let j=0;j<=i;j++){
            stars2[j].classList.remove("fa-star-o");
            stars2[j].classList.add("fa-star");
        }
    });
    stars2[i].addEventListener("click",function(){
        index2=i;
        kvalitet.value = index2 + 1;
    });
    stars2[i].addEventListener("mouseout",function(){
        for(let j=0;j<stars2.length;j++){
            stars2[j].classList.remove("fa-star");
            stars2[j].classList.add("fa-star-o");
        }
        for(let j=0;j<=index2;j++){
            stars2[j].classList.remove("fa-star-o");
            stars2[j].classList.add("fa-star");
        }
    });
}