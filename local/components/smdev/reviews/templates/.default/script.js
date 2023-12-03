class Rating {
    constructor(dom) {
        dom.innerHTML = '<svg width="110" height="20"></svg>';
        this.svg = dom.querySelector('svg');
        for(var i = 0; i < 5; i++)
            this.svg.innerHTML += `<polygon data-value="${i+1}"
           transform="translate(${i*22},0)" 
           points="10,1 4,19.8 19,7.8 1,7.8 16,19.8">`;
        this.svg.onclick = e => this.change(e);

        this.render();
    }

    change(e) {
        let value = e.target.dataset.value;
        value && (this.svg.parentNode.dataset.value = value);
        this.render();
    }
    render() {
        this.svg.querySelectorAll('polygon').forEach(star => {
            //let pointer = this.svg.parentNode.style.cssText = "pointer-events:none";
            let on = +this.svg.parentNode.dataset.value >= +star.dataset.value;
            star.classList.toggle('active', on);


        });
    }
}



$(document).ready(function () {
    $('#reviews_to').on('click',function(e) {

        var first_name = $('#name').val();
        var email = $('#email').val();
        var textarea = $('#review_text').val();
        let tent = $('#tent').val();
        var error = false;
        let rating = $('#raiting_reviews').data('value');

        $('input').removeClass('error');
        $('textarea').removeClass('error');
        if (typeof rating == "undefined"){
            $('.error_message').html('<div class="alert alert-danger" role="alert">Укажите рейтинг</div>');
            error = true;
        }else{
            $('.error_message').html('');
            $('span.rating').css( 'pointer-events', 'none')
        }
        if (tent.length > 0) {
            $('#tent').addClass('error');
            error = true;
        }
        if (first_name.length< 1) {
            $('#name').addClass('error');
            error = true;
        }
        if (textarea.length< 1) {
            $('#review_text').addClass('error');
            error = true;
        }
        if (email.length< 1) {
            $('#email').addClass('error');
            error = true;
        } else {
            var regEx = /^(([^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*)|(".+"))@(([^<>()[\].,;:\s@"]+\.)+[^<>()[\].,;:\s@"]{2,})$/iu;
            var validEmail = regEx.test(email);
            if (!validEmail) {
                $('#email').addClass('error');
                error = true;
            }
        }
        //error =false;
        if (error) {
            e.preventDefault();
        }else {
            let id = $('input[name=id]').val()
            let elementid = $('input[name=elementid]').val()
            $.ajax({
                type: "POST",
                url: '/local/components/smdev/reviews/templates/.default/ajax/ajax.php',
                data: {first_name: first_name, email:email, textarea:textarea ,id:id, rating:rating, elementid: elementid },
                timeout: 3000,
                error: function (request, error) {
                    if (error == "timeout") {
                        alert('timeout');
                    } else {
                        alert('Error! Please try again!');
                    }
                },
                success: function (data) {
                    JSON.parse(data)
                    console.log(data)
                    if (data){
                        $('#reviews_dev').hide(500);
                        $('.suc').html('<div class="alert alert-success" role="alert" style="text-align: center"> Благодарим за оставленный отзыв !!! <br>Отзыв успешно сохранен.</div>').delay(3000).slideUp(300)
                    }else{
                        $('.error_message').html('<div class="alert alert-danger" role="alert">Произошла ошибка. Пожалуйста отправьте позже.</div>');
                    }
                    var answe = data;
                    $('.answer').text(data)
                }
            });
        }
    });
    document.querySelectorAll('.rating').forEach(dom => new Rating(dom));

    $().fancybox({
        selector : '.gal_image',
        backFocus : false
    });
    // $(".gal_image").slick({
    //     slidesToShow   : 3,
    //     infinite : true,
    //     dots     : false,
    //     arrows   : false
    // });
    function gallery_hide() {
        let count_element;
        count_element = $(".cust").length
        $(".cust").each(function (key, value) {
            if (key > 13) {
                $(this).addClass('hide_image');
            }
            if (key == 13) {
                let count = count_element - key;
                $(this).find('span').html('+' + count);
                $(this).on('click', function (){
                    $(this).removeClass('show_con');
                    $('.hide_image').toggle(300);
                });
            }

        });

    }
    gallery_hide();
});