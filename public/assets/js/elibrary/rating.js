const allStar = document.querySelectorAll('.rating .star')
const ratingValue = document.querySelector('.rating input')
const cancelButton = document.querySelector('.btn.cancel');
var modal = document.getElementById("myModal");
allStar.forEach((item, idx)=> {
	item.addEventListener('click', function () {
		let click = 0
		ratingValue.value = idx + 1

		allStar.forEach(i=> {
			i.classList.replace('bxs-star', 'bx-star')
			i.classList.remove('active')
		})
		for(let i=0; i<allStar.length; i++) {
			if(i <= idx) {
				allStar[i].classList.replace('bx-star', 'bxs-star')
				allStar[i].classList.add('active')
			} else {
				allStar[i].style.setProperty('--i', click)
				click++
			}
		}
	})
})

cancelButton.addEventListener('click', function() {
    
    allStar.forEach(star => {
        if (star.classList.contains('bxs-star')) {
            star.classList.replace('bxs-star', 'bx-star');
            star.classList.remove('active');
            
        }
    });
   
    

});