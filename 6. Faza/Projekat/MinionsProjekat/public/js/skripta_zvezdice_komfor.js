let stars3 = document.querySelector(".ratings3").children;
const komfor = document.querySelector("#komfor");
let index3;

for(let i=0;i<stars3.length;i++){
    stars3[i].addEventListener("mouseover",function(){
        for(let j=0;j<stars3.length;j++){
            stars3[j].classList.remove("fa-star");
            stars3[j].classList.add("fa-star-o");
        }
        for(let j=0;j<=i;j++){
            stars3[j].classList.remove("fa-star-o");
            stars3[j].classList.add("fa-star");
        }
    });
    stars3[i].addEventListener("click",function(){
        index3=i;
        komfor.value = index3 + 1;
    });
    stars3[i].addEventListener("mouseout",function(){
        for(let j=0;j<stars3.length;j++){
            stars3[j].classList.remove("fa-star");
            stars3[j].classList.add("fa-star-o");
        }
        for(let j=0;j<=index3;j++){
            stars3[j].classList.remove("fa-star-o");
            stars3[j].classList.add("fa-star");
        }
    });
}