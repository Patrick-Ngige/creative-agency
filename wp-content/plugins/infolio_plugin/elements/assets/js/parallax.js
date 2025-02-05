    jQuery(document).ready(function() {
        const link = document.querySelectorAll('.infolio-social-media .infolio-hover-this');
        const cursor = document.querySelector('.infolio-cursor');
        const animateit = function (e) {
            const hoverAnim = this.querySelector('.infolio-social-media .infolio-hover-anim');
            const { offsetX: x, offsetY: y } = e,
                { offsetWidth: width, offsetHeight: height } = this,
                move = 25,
                xMove = x / width * (move * 2) - move,
                yMove = y / height * (move * 2) - move;
            hoverAnim.style.transform = `translate(${xMove}px, ${yMove}px)`;
            if (e.type === 'mouseleave') hoverAnim.style.transform = '';
        };
        const editCursor = e => {
            const { clientX: x, clientY: y } = e;
        };
        link.forEach(b => b.addEventListener('mousemove', animateit));
        link.forEach(b => b.addEventListener('mouseleave', animateit));
        window.addEventListener('mousemove', editCursor);

        jQuery("a, .cursor-pointer").hover(
            function () {
                jQuery(".infolio-cursor").addClass("cursor-active");
            }, function () {
                jQuery(".infolio-cursor").removeClass("cursor-active");
            }
        );
    });