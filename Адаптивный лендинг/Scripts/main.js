const swiper1 = new Swiper('.speakers-swiper', {
    // Optional parameters
    direction: 'horizontal',
    loop: true,

    // If we need pagination
    pagination: {
	el: '.speakers-swiper-pagination',
	clickable: true,
    },

    // Navigation arrows
    navigation: {
	nextEl: '.speakers-button-next',
	prevEl: '.speakers-button-prev',
    },
    breakpoints: {
	1240: {
	    slidesPerView: 2,
	    pagination: {
		dynamicBullets: false
	    }
	},
	768: {
	    slidesPerView: 2,
	    pagination: {
		dynamicBullets: false
	    }
	},
	200: {
	    slidesPerView: 1,
	    pagination: {
		dynamicBullets: true
	    }
	}
    }
},)
const swiper2=new Swiper('.photos-swiper',{
    direction: 'horizontal',
    navigation: {
	nextEl: '.photos-button-next',
	prevEl: '.photos-button-prev',
    },
    spaceBetween: 40,

    breakpoints: {
	1240: {
	    grid: {
		rows: 4,
		fill: 'row',
		spaceBetween: 10
	    },
	    slidesPerView: 4,
	    pagination: {
		dynamicBullets: false
	    }
	},
	768: {
	    grid: {
		rows: 2,
		fill: 'row',
		spaceBetween: 10
	    },
	    slidesPerView: 2,
	    slidesPerGroup:2,
	    pagination: {
		dynamicBullets: false
	    }
	},
	200: {
	    slidesPerView: 1,
	    pagination: {
		dynamicBullets: true
	    }
	}
    },
    pagination: {
	el: '.photos-swiper-pagination',
	clickable: true,
    },
})
window.onresize = function(event) {
if(window.outerWidth>1240){
    setMenuVisible(false)
}
};
function validateMsgForm() {
    let mfName, mfEmail, mfMsg, valid = true
    const emailRegExp = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    mfName = document.querySelector("#mf-name")
    mfEmail = document.querySelector("#mf-email")
    mfMsg = document.querySelector("#mf-message")
    if (mfName.value.trim().length === 0) {
	valid = false;
	mfName.style.border="3px solid #FB5555";
    } else mfName.style.border="none";
    if (!mfEmail.value || !emailRegExp.test(mfEmail.value)) {
	valid = false;
	mfEmail.style.border="3px solid #FB5555";
    } else mfEmail.style.border="none";
    if (mfMsg.value.trim().length === 0) {
	valid = false;
	mfMsg.style.border="3px solid #FB5555";
    } else mfMsg.style.border="none";
    if (valid) {
	console.log("Валидация формы сообщения успешна!")
	console.log("Имя: " + mfName.value)
	console.log("Email: " + mfEmail.value)
	console.log("Сообщение: " + mfMsg.value)
    }
}

function validateRegForm() {
    let firstName, lastName, company, job, email, agree, valid = true
    const emailRegExp = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    firstName = document.querySelector("#rf-first-name")
    lastName = document.querySelector("#rf-last-name")
    company = document.querySelector("#rf-company")
    job = document.querySelector("#rf-job")
    email = document.querySelector("#rf-email")
    agree = document.querySelector("#rf-agree")
    if (firstName.value.trim().length === 0) {
	valid = false;
	firstName.style.border="3px solid #FB5555";
    } else firstName.style.border="none";
    if (lastName.value.trim().length === 0) {
	valid = false;
	lastName.style.border="3px solid #FB5555";
    } else lastName.style.border="none";
    if (company.value.trim().length === 0) {
	valid = false;
	company.style.border="3px solid #FB5555";
    } else company.style.border="none";
    if (job.value.trim().length === 0) {
	valid = false;
	job.style.border="3px solid #FB5555";
    } else job.style.border="none";
    if (!email.value || !emailRegExp.test(email.value)) {
	valid = false;
	email.style.border="3px solid #FB5555";
    } else email.style.border="none";
    if (!agree.checked) {
	valid = false;
	agree.classList.add("invalidCheckbox");
    } else agree.classList.remove("invalidCheckbox");
    if (valid) {
	console.log("Валидация формы регистрации успешна!")
	console.log("Имя: " + firstName.value)
	console.log("Фамилия: " + lastName.value)
	console.log("Компания: " + company.value)
	console.log("Должность: " + job.value)
	console.log("Email: " + email.value)
    }
}

function showRegModal() {
    window.scrollTo({top: 0});
    let modal = document.querySelector("#reg-modal")
    let menuBtn = document.querySelector("#show-menu-btn")
    let menu = document.querySelector("#mobile-menu")
    let menuCloseBtn = document.querySelector("#close-menu-btn")
    modal.style.display = "block"
    menuCloseBtn.style.display = "block"
    menuBtn.style.display = "none"
    menu.style.display = "none"
    document.body.style.overflowY = "hidden"
    modal.style.overflowY = "auto"
}

function hideRegModal(e) {
    let modal = document.querySelector("#reg-modal")
    let menu = document.querySelector("#show-menu-btn")
    if (!e) {
	modal.style.display = "none"
	document.body.style.overflowY = "auto"
	menu.style.display = "block"
	return
    } else {
	const div = document.querySelector("#reg-modal-win")
	const withinBoundaries = e.composedPath().includes(div);
	let modal = document.querySelector("#reg-modal")
	if (!withinBoundaries) {
	    modal.style.display = "none"
	    document.body.style.overflowY = "auto"
	    modal.style.overflowY = "hidden"
	}
    }
}

function setMenuVisible(flag) {
    let menu = document.querySelector("#mobile-menu")
    let menuOpenBtn = document.querySelector("#show-menu-btn")
    let menuCloseBtn = document.querySelector("#close-menu-btn")
    let modal = document.querySelector("#reg-modal")
    if(modal.style.display=="block" && flag==false){
	hideRegModal()
	menuCloseBtn.style.display = "none"
	return
    }
    if (flag) {
	document.body.style.overflowY = "hidden"
	menu.style.overflowY = "auto"
	menuCloseBtn.style.display = "block"
	menuOpenBtn.style.display = "none"
	menu.style.display = "block"
    } else {
	document.body.style.overflowY = "auto"
	menuCloseBtn.style.display = "none"
	menuOpenBtn.style.display = "block"
	menu.style.overflowY = "hidden"
	menu.style.display = "none"
    }
}
