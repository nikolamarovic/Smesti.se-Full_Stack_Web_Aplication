const stars1 = document.querySelector(".ratings1").children;
const cistoca = document.querySelector("#cistoca");
let index1;

for(let i=0;i<stars1.length;i++){
    stars1[i].addEventListener("mouseover",function(){
        for(let j=0;j<stars1.length;j++){
            stars1[j].classList.remove("fa-star");
            stars1[j].classList.add("fa-star-o");
        }
        for(let j=0;j<=i;j++){
            stars1[j].classList.remove("fa-star-o");
            stars1[j].classList.add("fa-star");
        }
    });
    stars1[i].addEventListener("click",function(){
        index1=i;
        cistoca.value = index1 + 1;
        
    });
    stars1[i].addEventListener("mouseout",function(){
        for(let j=0;j<stars1.length;j++){
            stars1[j].classList.remove("fa-star");
            stars1[j].classList.add("fa-star-o");
        }
        for(let j=0;j<=index1;j++){
            stars1[j].classList.remove("fa-star-o");
            stars1[j].classList.add("fa-star");
        }
    });
}