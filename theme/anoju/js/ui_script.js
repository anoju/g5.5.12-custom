/* author :  an.hyo-ju ( anoju@cntt.co.kr ) in CNTT */
$(function () {
  common.init();
  popupUI();
  tapMotion();
  faqMotion();

  $(window).on('scroll', scrollItem);
  $(window).trigger('scroll');

  effect.init();
});
var effect = {
  loadingShow: function () {
    var $html = '<div class="loading off"></div>';
    if (!$('.loading').length) $('body').prepend($html);

    setTimeout(function () {
      $('.loading').removeClass('off');
    }, 1);
  },
  loading: function () {
    if ($('.loading').length) {
      $('.loading')
        .addClass('off')
        .delay(500)
        .queue(function (next) {
          $('.loading').remove();
          if (!isMobile.any()) effect.visual();
          next();
        });
    } else {
      if (!isMobile.any()) effect.visual();
    }
  },
  visual: function () {
    if ($('.visual').length) {
      $('.visual').addClass('off');
      setTimeout(function () {
        $('.visual')
          .addClass('on')
          .delay(2500)
          .queue(function (next) {
            $('.visual').removeClass('on off');
            next();
          });
      }, 1);
      $(window)
        .scroll(function () {
          var scrollTop = $(this).scrollTop();
          var $bg = $('.visual .bg');
          if ($bg.length) $bg.css({ 'margin-top': Math.max(0, (scrollTop / 3) * 2) });

          var $youtube = $('.youtube');
          if ($youtube.length) $youtube.css({ 'margin-top': Math.max(0, (scrollTop / 3) * 2) });
        })
        .scroll();
    }
  },
  click: function () {
    $(document).on('click', 'a', function (e) {
      // e.preventDefault();
      var $href = $(this).attr('href');
      var $target = $(this).attr('target');
      var $onclick = $(this).attr('onclick');
      if ($href.indexOf('http') >= 0 && $target !== '_blank' && !$onclick) {
        effect.loadingShow();
      }
    });
  },
  init: function () {
    effect.click();

    if ($('.visual').length && !isMobile.any()) $('.visual').addClass('off');
    $(window).load(function () {
      effect.loading();
    });
  }
};

var common = {
  header: function () {
    var $header = $('#header'),
      $gnbTxt = $('#gnb a'),
      $title = $.trim($('#pageTit').text()),
      $btnGnb = $('.btn_gnb'),
      $gnbWrap = $('.gnb_wrap'),
      $gnb = $('#gnb'),
      $gnbDepth1 = $('#gnb > ul > li > a'),
      $visual = $('.visual'),
      $mSize = 760;

    //document.title = $title + ' | 한국산업은행지부';
    //$title = $title.replace(' 글쓰기','')
    //$title = $title.replace(' 글수정','')

    var $locationArry = [],
      $locationUl = [],
      $liLength,
      $ul,
      $a;

    //gnb active
    $gnbTxt.each(function () {
      if ($(this).text() == $title) {
        var $parents = $(this).parents('li');
        $parents.addClass('active');
        $liLength = $parents.length;
        for (i = 0; i < $liLength; i++) {
          $li = $parents.eq(i).clone();
          $li.find('ul').remove();
          //console.log($li)
          $locationArry.push($li);

          $ul = $parents.eq(i).closest('ul').clone();
          $ul.find('ul').remove();
          $locationUl.push($ul);
        }
      }
    });
    //location
    if ($('#location').length > 0) {
      for (i = 0; i < $locationArry.length; i++) {
        $('#location > li').first().after($locationArry[i]);
        $('#location > li').eq(1).append($locationUl[i]);
      }
    }
    $(document).on('click', '#location > li > a', function (e) {
      e.preventDefault();
      console.log('location');
      $(this).parent().toggleClass('on');
      $(this).siblings('ul').stop().slideToggle();
    });

    //visual
    if ($visual.length > 0) {
      var $dep1 = $('#gnb > ul > li.active > a').text();
      //console.log($dep1)
      if ($title == '회원가입약관' || $title == '회원 가입' || $title == '회원가입완료') $visual.addClass('member');
      if ($title == '회원 정보 수정') $visual.addClass('mypage');
      if ($title == '노동조합 소개' || $dep1 == '노동조합 소개') $visual.addClass('intro');
      if ($title == '노동조합 알림' || $dep1 == '노동조합 알림') $visual.addClass('news');
      if ($title == '열린광장' || $dep1 == '열린광장') $visual.addClass('plaza');
      if ($title == '설문조사 및 접수' || $dep1 == '설문조사 및 접수') $visual.addClass('plaza');
      if ($title == '자료실' || $dep1 == '자료실') $visual.addClass('data');
    }

    //mobile gnb button
    $btnGnb.click(function (e) {
      e.preventDefault();
      if ($header.hasClass('gnb_open')) {
        $header.removeClass('gnb_open');
        $btnGnb.find('span').text('모바일 GNB열기');
      } else {
        $header.addClass('gnb_open');
        $btnGnb.find('span').text('모바일 GNB닫기');
      }
    });

    //gnb UI
    $gnb.mouseenter(function () {
      if ($(window).width() > $mSize) $header.addClass('gnb_open');
    });
    $gnbWrap.mouseleave(function () {
      if ($(window).width() > $mSize) {
        $header.removeClass('gnb_open');
      }
    });
    $gnbTxt.focus(function () {
      if ($(window).width() > $mSize) $header.addClass('gnb_open');
    });
    $gnbTxt.blur(function () {
      if ($(window).width() > $mSize) {
        setTimeout(function () {
          if (!$('#gnb a').is(':focus')) {
            $header.addClass('gnb_open');
          }
        }, 10);
      }
    });

    //cafe btn
    //활용
    if ($('.head_cafe').length) cafeOn();
    function cafeOn() {
      $('.head_cafe b').addRemoveClass('fadeInDown', 0, 1000);
      $('.head_cafe i').addRemoveClass('tada', 1000, 2000);
      setTimeout(cafeOn, 4000);
    }
    //member_box
    $('.btn_member').click(function (e) {
      if ($(window).width() > $mSize || $(this).hasClass('btn_user')) {
        e.preventDefault();
        $('.member_box').stop().slideToggle();
      }
    });
    $('.member_box .btn_close').click(function (e) {
      e.preventDefault();
      $('.member_box').stop().slideUp();
    });

    //foot_navi
    if ($('.foot_navi').length > 0) {
      $('.foot_navi > div').append($('#gnb > ul').clone());
    }
  },
  form: function () {
    $('input, textarea').placeholder();

    //spinner
    if ($('.spinner').size() > 0) {
      $('.spinner').spinner({
        min: 1,
        create: function (event, ui) {
          //add custom classes and icons
          $(this).next().html('<i class="icon icon-plus">더하기</i>').next().html('<i class="icon icon-minus">빼기</i>');
        }
      });
    }

    //datepicker
    if ($('.datepicker').size() > 0) {
      $('.datepicker').datepicker({
        closeText: '닫기',
        prevText: '이전달',
        nextText: '다음달',
        currentText: '오늘',
        monthNamesShort: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
        monthNames: ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        dateFormat: 'yy-mm-dd',
        showMonthAfterYear: true,
        showOn: 'both',
        buttonText: '<i class="fa fa-calendar"></i><span class="blind">기간조회</span>'
      });
    }

    //tooltip
    $(document).tooltip({
      items: '.tooltip, .tooltip-img, [data-tooltip-img]',
      track: true,
      content: function () {
        var element = $(this);
        if (element.is('[data-tooltip-img]')) {
          var img = element.data('tooltip-img'),
            alt = element.data('tooltip-alt');
          return "<img src='" + img + "' alt='" + alt + "'/>";
        }
        if (element.hasClass('tooltip-img')) {
          return element.attr('alt');
        }
        if (element.hasClass('tooltip')) {
          return element.attr('title');
        }
      }
    });

    //inputFile
    $('.inp_file').click(function () {
      console.log('aaa');
    });
    $('.inp_file .input').click(function () {
      console.log('aaa');
      $(this).siblings('.btn_file').find('input').trigger('click');
    });
    $('.inp_file .btn_file .button').click(function (e) {
      e.preventDefault();
      $(this).siblings('input').trigger('click');
    });
    $('.inp_file .btn_file input').change(function () {
      $(this).closest('.inp_file').find('.input').val($(this).val());
    });

    if ($('.inp_spinner').length > 0) {
      $('.inp_spinner').each(function () {
        var $this = $(this),
          $min = $this.data('min'),
          $max = $this.data('max'),
          $input = $this.find('.input'),
          $inputVal = $input.val(),
          $btn = $this.find('.btn');

        $input.after('<select class="select" title="수량선택"><option value="0">직접입력</option></select>');
        var $select = $this.find('.select');

        //console.log($inputVal)

        //세팅
        for (i = $min; i <= $max; i++) {
          $select.append($('<option>', { value: i, text: i }));
        }
        if ($inputVal == '' || $inputVal == null) {
          $input.val($min);
          $select.val($min);
        }

        //셀렉트
        $select.change(function () {
          var $val = $(this).val();
          if ($val == '0') {
            $select.addClass('hide');
            $input.addClass('on').attr('readonly', false).focus();
          } else {
            $input.val($val);
          }
        });

        //숫자 입력시
        $input.change(function () {
          var $val = $(this).val();
          if ($min <= $val && $val <= $max) {
            $select.val($val).removeClass('hide');
            $input.removeClass('on').attr('readonly', true);
          } else {
            alert($min + '에서 ' + $max + '까지만 입력 가능합니다.\n다시 입력해주세요');
            $input.val($min);
            $select.val($min);
          }
        });
        var $firstVal;
        $input.focusin(function () {
          $firstVal = $(this).val();
        });
        $input.focusout(function () {
          var $lastVal = $(this).val();
          if ($firstVal == $lastVal) {
            //console.log($firstVal,$lastVal)
            $select.val($lastVal).removeClass('hide');
            $input.removeClass('on').attr('readonly', true);
          }
        });

        //버튼 클릭
        $btn.click(function (e) {
          e.preventDefault();
          var $val = $input.val(),
            $val2 = $select.val();
          if ($(this).hasClass('btn_minus')) {
            $val--;
            if ($val < $min) {
              alert('최소수량은 ' + $min + '개 입니다.');
              $val = $min;
            }
          } else {
            $val++;
            if ($val > $max) {
              alert('최대수량은 ' + $max + '개 입니다.');
              $val = $max;
            }
          }
          //var last = Math.max($min,Math.min($val,$max))

          $input.val($val);
          $select.val($val);
        });
      });
    }
  },
  top: function () {
    var settings = {
      button: '#btnTop',
      text: '컨텐츠 상단으로 이동',
      min: 100,
      fadeIn: 400,
      fadeOut: 400,
      scrollSpeed: 800,
      easingType: 'easeInOutExpo'
    };

    $('body').append('<a href="#" id="' + settings.button.substring(1) + '" title="' + settings.text + '">' + settings.text + '</a>');
    $(settings.button)
      .on('click', function (e) {
        $('html, body').animate({ scrollTop: 0 }, settings.scrollSpeed, settings.easingType);
        e.preventDefault();
      })
      .on('mouseenter', function () {
        $(settings.button).addClass('hover');
      })
      .on('mouseleave', function () {
        $(settings.button).removeClass('hover');
      });

    $(window).scroll(function () {
      var position = $(window).scrollTop();
      if (position > settings.min) {
        $(settings.button).fadeIn(settings.fadeIn);
      } else {
        $(settings.button).fadeOut(settings.fadeOut);
      }
    });
  },
  init: function () {
    common.header();
    common.form();
    common.top();
  }
};

//Tap
function tapMotion() {
  var $tab = $('.tab_motion'),
    $wrap = $('.tab_wrap');

  $tab.on('click', 'a', function () {
    if (!$(this).parent().hasClass('on')) {
      var href = $(this).attr('href');
      $(href).addClass('on').siblings('.tab_cont').removeClass('on');
      $(this).parent().addClass('on').siblings().removeClass('on');
      $(this).parents('.tabmenu').removeClass('tab_open');
    } else {
      $(this).parents('.tabmenu').toggleClass('tab_open');
    }
    return false;
  });

  $(window).load(function () {
    var speed = 500,
      $href = location.href,
      $tabId = $.url($href).param('tabId'),
      $tabIdx = $.url($href).param('tabIdx'),
      $SclId = $.url($href).param('SclId'),
      $id = $('#' + $SclId);

    if ($tab.length > 0) {
      $tab.each(function (index, element) {
        var $this = $(this),
          $id2 = $this.attr('id');
        if ($id2 == $tabId && $tabIdx > 0) {
          $this.children('li').eq($tabIdx).find('a').trigger('click');
        } else {
          $this.children('li').eq(0).find('a').trigger('click');
        }
      });
    }

    if ($id.length > 0 && $id.is(':visible')) {
      var $top = $id.offset().top;
      $(window).scrollTo($top, speed);
    }

    if ($wrap.length > 0) {
      $(window).scroll(function () {
        var $scrollTop = $(this).scrollTop();

        $wrap.each(function (index, element) {
          var $this = $(this),
            $top2 = $this.offset().top,
            $st = Math.floor($top2);
          //console.log(index,$scrollTop,$contPt,$st)
          if ($st <= $scrollTop) {
            //console.log(index)
            $this.addClass('fixed');
          } else {
            $this.removeClass('fixed');
          }
        });
      });
    }
  });

  $('.rdo_tabmenu .radio input').change(function () {
    var $val = $(this).val();
    $('#' + $val)
      .addClass('on')
      .siblings('.rdo_cont')
      .removeClass('on');
  });

  if ($('.rdo_tabmenu').length > 0) {
    $('.rdo_cont').eq(0).addClass('on');
  }
}

//알럿
function alertTip(tar, txt) {
  var $this = $(tar),
    $delay = 1000,
    $speed = 300;

  if ($this.length > 0) {
    var $left = $this.offset().left,
      $top = $this.offset().top,
      $height = $this.outerHeight(),
      $tip = $('<div class="alert_tip" style="left:' + $left + 'px;top:' + ($top + $height) + 'px;">' + txt + '</div>');

    $('body').append($tip);
    $tip
      .fadeIn($speed)
      .delay($delay)
      .fadeOut($speed, function () {
        $tip.remove();
      });
    $this
      .addClass('error')
      .focus()
      .delay($delay)
      .queue(function (next) {
        $this.removeClass('error');
        next();
      });
  }
}

//resizeEnd
$(window).resize(function () {
  if (this.resizeTO) {
    clearTimeout(this.resizeTO);
  }
  this.resizeTO = setTimeout(function () {
    $(this).trigger('resizeEnd');
  }, 300);
});

//팝업 UI
function popOpen(tar) {
  var $speed = 300,
    $pop = $(tar).find('.pop_wrap');
  var $wrapH, $popH, $mT;

  $('body').addClass('hidden');
  $(tar).fadeIn($speed);
  popPositin(tar, 300);
  $(window).on('resizeEnd', function () {
    popPositin(tar, 300);
  });
}
function popPositin(tar, speed) {
  //console.log($(tar).attr('id'))
  var $wrapH = $(tar).height(),
    $pop = $(tar).find('.pop_wrap'),
    $popH = $pop.outerHeight(),
    $mT = Math.max(0, ($wrapH - $popH) / 2);
  if (speed > 100) {
    $pop.stop().animate({ 'margin-top': $mT }, speed);
  } else {
    $pop.css({ 'margin-top': $mT });
  }
}
function popupUI() {
  $('.pop_open').on('click', function (e) {
    e.preventDefault();
    var pop = $(this).attr('href');
    popOpen(pop);
  });
  $('.pop_close').on('click', function (e) {
    e.preventDefault();
    var pop = $(this).closest('.pop_bg');
    popClose(pop);
  });

  $('.pop_bg')
    .on('click', function () {
      var vCont = $(this);
      if (!vCont.hasClass('close_none')) {
        popClose(vCont);
      }
    })
    .on('click', '.pop_wrap', function (e) {
      e.stopPropagation();
    });
}
function popClose(tar) {
  $('body').removeClass('hidden');
  $(tar).fadeOut(300, function () {
    $(tar).removeAttr('style');
    $(tar).find('.pop_wrap').removeAttr('style');
  });
}

//오늘하루 팝업
function todayPopup() {
  var $speed = 500;
  var popList = [];

  if ($('.pop_today').length > 0) {
    $('.pop_today').each(function () {
      var $id = $(this).attr('id');
      popList.push($id);
    });
  }

  $('.pop_today .pop_modal_close').click(function (e) {
    var chk = $(this).closest('.pop_today').find('.todayChk'),
      $id = $(this).closest('.pop_today').attr('id');

    if (chk.is(':checked')) {
      setCookie($id, 'done', 1);
    }
    $('#' + $id).hide($speed);
  });

  for (var i in popList) {
    if (cookiedata.indexOf(popList[i] + '=done') < 0) {
      $('#' + popList[i]).show($speed);
    }
  }
}

//faq
function faqMotion() {
  $('.faq_list dt a').click(function () {
    $(this).parent('dt').toggleClass('on').siblings('dt').removeClass('on');
    $(this).parent().next().slideToggle(300).siblings('dd').slideUp(300);
    return false;
  });
}

//scroll-animation
function scrollItem() {
  var $elements = $('*[data-animation]');
  offset = $(window).scrollTop() + $(window).height();

  if ($elements.size() == 0) {
    $(window).off('scroll', scrollItem);
  }

  $elements.each(function (i) {
    var $el = $(this),
      $animationClass = $el.data('animation'),
      $delay = $el.data('delay'),
      $duration = $el.data('duration');

    if (!$el.hasClass('animated')) {
      $el.data('top', $el.offset().top);

      if ($delay > 0) {
        $el.css({
          '-webkit-animation-delay': $delay + 'ms',
          'animation-delay': $delay + 'ms'
        });
      }
      if ($duration > 0) {
        $el.css({
          '-webkit-animation-duration': $duration + 'ms',
          'animation-duration': $duration + 'ms'
        });
      }

      $el.addClass($animationClass + ' animated wait-animation');
    }
    $(window).resize(function () {
      $el
        .removeClass($animationClass)
        .data('top', $el.offset().top)
        .delay(10)
        .queue(function () {
          $el.addClass($animationClass).dequeue();
        });
    });
    //console.log($el.data('top'))
    if ($el.data('top') + $el.height() / 4 < offset) {
      $el.removeClass('wait-animation');
    }
  });
}

//multi-swiper
function multiSwiper(tar) {
  var sliders = [];
  $(tar).each(function (i, element) {
    var $list = $(this).find('.swiper-container'),
      $prev = $(this).find('.ui-prev'),
      $next = $(this).find('.ui-next'),
      $pagination = $(this).find('.pagination'),
      $length = $list.find('.swiper-slide').length;

    //console.log($length);

    $list.addClass('ui-swipe-s' + i);
    if ($prev.length > 0) {
      $prev.addClass('ui-swipe-l' + i);
    }
    if ($next.length > 0) {
      $next.addClass('ui-swipe-r' + i);
    }
    if ($pagination.length > 0) {
      $pagination.addClass('ui-swipe-p' + i);
    }
    var slider = new Swiper('.ui-swipe-s' + i, {
      slidesPerView: 'auto',
      calculateHeight: true,
      pagination: '.ui-swipe-p' + i,
      paginationClickable: true,
      resizeReInit: true,
      onInit: function (swiper) {
        var wid = $(swiper.container).width(),
          wid2 = $(swiper.container).find('.swiper-wrapper').width();
        //console.log(wid,wid2,i)
        $('.ui-swipe-l' + i).addClass('disabled');
        if (wid >= wid2) {
          $('.ui-swipe-r' + i).addClass('disabled');
        }
      },
      onSlideChangeStart: function (swiper) {
        var $i = swiper.activeIndex,
          $l = swiper.visibleSlides.length;
        //console.log($i,$l);
        if ($i == 0) {
          $('.ui-swipe-l' + i).addClass('disabled');
        } else {
          $('.ui-swipe-l' + i).removeClass('disabled');
        }
        if ($i + $l == $length) {
          $('.ui-swipe-r' + i).addClass('disabled');
        } else {
          $('.ui-swipe-r' + i).removeClass('disabled');
        }
      }
    });

    sliders.push(slider);

    $('.ui-swipe-l' + i).click(function (e) {
      e.preventDefault();
      sliders[i].swipePrev();
    });
    $('.ui-swipe-r' + i).click(function (e) {
      e.preventDefault();
      sliders[i].swipeNext();
    });
  });
}

//loading
function loadingShow() {
  var $loading = $('<div id="loading"><p><img src="' + imgLoadingPath + '" alt="페이지를 불러오는 중입니다."/></p></div>'),
    $id = $('#loading');

  if ($id.length == 0) {
    $('body').append($loading);
  }
}
function loadingHide() {
  var $id = $('#loading');
  $id.remove();
}

//안드로이드 버전체크
var ua = navigator.userAgent;
if (ua.indexOf('Android') >= 0) {
  var androidversion = parseFloat(ua.slice(ua.indexOf('Android') + 8));
}

//모바일 에이전트 구분
var isMobile = {
  Android: function () {
    return navigator.userAgent.match(/Android/i) == null ? false : true;
  },
  BlackBerry: function () {
    return navigator.userAgent.match(/BlackBerry/i) == null ? false : true;
  },
  IOS: function () {
    return navigator.userAgent.match(/iPhone|iPad|iPod/i) == null ? false : true;
  },
  Opera: function () {
    return navigator.userAgent.match(/Opera Mini/i) == null ? false : true;
  },
  Windows: function () {
    return navigator.userAgent.match(/IEMobile/i) == null ? false : true;
  },
  any: function () {
    return isMobile.Android() || isMobile.BlackBerry() || isMobile.IOS() || isMobile.Opera() || isMobile.Windows();
  }
};
