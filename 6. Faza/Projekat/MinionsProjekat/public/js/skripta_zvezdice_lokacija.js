const stars5 = document.querySelector(".ratings5").children;
const lokacija = document.querySelector("#lokacija");
let index5;

for(let i=0;i<stars5.length;i++){
    stars5[i].addEventListener("mouseover",function(){
        for(let j=0;j<stars5.length;j++){
            stars5[j].classList.remove("fa-star");
            stars5[j].classList.add("fa-star-o");
        }
        for(let j=0;j<=i;j++){
            stars5[j].classList.remove("fa-star-o");
            stars5[j].classList.add("fa-star");
        }
    });
    stars5[i].addEventListener("click",function(){
        index5=i;
        lokacija.value = index5 + 1;
    });
    stars5[i].addEventListener("mouseout",function(){
        for(let j=0;j<stars5.length;j++){
            stars5[j].classList.remove("fa-star");
            stars5[j].classList.add("fa-star-o");
        }
        for(let j=0;j<=index5;j++){
            stars5[j].classList.remove("fa-star-o");
            stars5[j].classList.add("fa-star");
        }
    });
}