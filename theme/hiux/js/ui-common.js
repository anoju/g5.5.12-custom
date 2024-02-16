$(function () {
  commonUI();
  mainUI();
  memeberUI();
});
$(window).on('resize', function () {
  vhChk();
});

vhChk();
function vhChk() {
  const $vh = window.innerHeight * 0.01;
  $('html').css('--vh', $vh + 'px');
}

function commonUI() {
  // gnb 메뉴

  const btnMenu = document.querySelector('.btn-menu');
  const $gnbMenu = $('.commonGnb > ol');
  const $gnbMenuClone = $gnbMenu.clone();
  $('.f-menu-list').html($gnbMenuClone);

  let $gnbTxt = $('.commonGnb li a');
  const $title = $.trim($('#pageTit').text());
  $gnbTxt.each(function () {
    if ($(this).text() === $title) {
      const $parents = $(this).parents('li');
      $parents.addClass('active');
    }
  });

  function menuPop() {
    const body = $('body');
    const openBtn = $('.header .btn-menu');

    let prevSclTop = window.scrollY || window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
    document.addEventListener('scroll', function () {
      const nowSclTop = window.scrollY || window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop;
      const sclDirection = nowSclTop > prevSclTop ? 'down' : 'up';
      const sclDistance = Math.abs(nowSclTop - prevSclTop);
      const elArray = [];
      const header = document.querySelector('.header');
      if (header) elArray.push(header);
      const tagSwiper = document.querySelector('.tag-menu');
      if (tagSwiper) elArray.push(tagSwiper);

      if (elArray.length) fixedClassChk(elArray, nowSclTop, sclDirection, sclDistance);

      prevSclTop = nowSclTop;
    });

    // GNB 메뉴
    btnMenu.addEventListener('click', function (e) {
      e.stopPropagation();
      document.body.classList.toggle('gnbPopup');
    });

    document.addEventListener('click', function (e) {
      const target = e.target;
      if (!target.matches('.btn-menu') && !target.matches('.gnbPopup') && !target.matches('.commonGnb')) {
        document.body.classList.remove('gnbPopup');
      }
    });
  }

  // 스크롤 top 버튼
  function scrollTop() {
    let scrollArea;
    const scrollBtn = $('.scroll-top');
    const wrapper = document.querySelector('#container');
    const btn = scrollBtn.children();

    scrollBtn.hide();

    if ($('#wrapper').hasClass('main')) {
      scrollArea = $('.contents-group-box .inner');
    } else {
      scrollArea = $(window);
    }

    scrollArea.scroll(function () {
      if ($(this).scrollTop() > 100) {
        scrollBtn.fadeIn();
      } else if (scrollArea.scrollTop() <= 0) {
        // 스크롤 0 일때 닫기
        setTimeout(function () {
          wrapper.classList.remove('active');
        }, 100);
      } else {
        scrollBtn.fadeOut();
      }
    });

    btn.on('click', function () {
      if ($('#wrapper').hasClass('main')) {
        scrollArea.animate({ scrollTop: 0 }, 800, function () {
          $(this).closest('#container').removeClass('active');
        });
      } else {
        $('html, body').animate({ scrollTop: 0 }, 500);
      }
    });
  }
  menuPop();
  scrollTop();
}

function fixedClassChk(elArray, nowSclTop, sclDirection, sclDistance) {
  elArray.forEach(function (item) {
    const itemEnd = getOffset(item).top + item.offsetHeight;
    if (nowSclTop > itemEnd) {
      item.classList.add('fixed');
      if (sclDistance > 5) {
        if (sclDirection === 'down') {
          item.classList.add('is-up');
        } else {
          item.classList.remove('is-up');
        }
      }
    } else {
      item.classList.remove('fixed', 'is-up');
    }
  });
}

// 메인
let $mainBanner;
let $mainWork;
function mainUI() {
  if (!$('#wrapper').hasClass('main')) return;
  const wrapper = document.querySelector('#container');
  const dragElement = document.querySelector('.main-slide-wrap');
  const cateList = document.querySelector('.contents-box');
  const scrollArea = $('.contents-group-box .inner');

  const btnMenu = document.querySelector('.contents-group-box .btn-open-career');
  let isDragging = false;
  let initialX;
  let initialY;

  // 메인 배너 스와이퍼
  $mainBanner = new Swiper('.main-swiper', {
    loop: true,
    preventInteractionOnTransition: false,
    pagination: {
      el: '.swiper-pagination',
      clickable: true
    }
  });

  // 메인 work 스와이퍼
  $mainWork = new Swiper('.small-swiper', {
    slidesPerView: 'auto'
  });

  // 메인 휠 스크롤,터치 무브 이벤트
  wrapper.addEventListener('mousedown', handleMouseDown);
  dragElement.addEventListener('touchstart', handleTouchStart, { passive: true });
  dragElement.addEventListener('wheel', handleWheel, { passive: true });

  document.addEventListener('mousemove', handleDrag);
  document.addEventListener('touchmove', handleTouchMove);

  document.addEventListener('mouseup', handleMouseUp);
  document.addEventListener('touchend', handleTouchEnd);

  btnMenu.addEventListener('click', menuToggle);
  //btnMenu.addEventListener('touchend', menuToggle);

  function menuToggle() {
    if (wrapper.classList.contains('active')) {
      wrapper.classList.remove('active');
    } else {
      wrapper.classList.add('active');
    }
  }

  function handleWheel(e) {
    const direction = e.deltaY > 0 ? 'down' : 'up';
    wrapper.classList.toggle('active', direction === 'down');
    scrollArea.scrollTop(1);
  }

  function handleMouseDown(e) {
    // 마우스 왼쪽 버튼(버튼 코드: 0)에 대한 클릭만 처리
    if (e.button === 0) {
      e.preventDefault();
      isDragging = true;
      initialX = e.clientX;
      initialY = e.clientY;
    }
  }

  function handleTouchStart(e) {
    e.preventDefault();
    isDragging = true;
    initialX = e.touches[0].clientX;
    initialY = e.touches[0].clientY;
  }

  function handleDrag(e) {
    if (isDragging) {
      let currentX = e.clientX;
      let currentY = e.clientY;
      handleDragMovement(currentX, currentY);
    }
  }

  function handleTouchMove(e) {
    if (isDragging) {
      let currentX = e.touches[0].clientX;
      let currentY = e.touches[0].clientY;
      handleDragMovement(currentX, currentY);
    }
  }

  function handleMouseUp() {
    isDragging = false;
  }

  function handleTouchEnd() {
    isDragging = false;
  }

  function handleDragMovement(currentX, currentY) {
    let deltaX = currentX - initialX;
    let deltaY = currentY - initialY;

    if (isInsideCateList(currentX, currentY)) {
      isDragging = false;
    }

    if (deltaY > 120) {
      wrapper.classList.remove('active');
    } else if (deltaY < -120) {
      wrapper.classList.add('active');
      scrollArea.scrollTop(1);
    }
  }

  function isInsideCateList(currentX, currentY) {
    const cateListRect = cateList.getBoundingClientRect();
    return currentY >= cateListRect.top && currentY <= cateListRect.bottom;
  }
}

//map
function kakakoMapInit(imgsrc, imgWidth, imgHeight) {
  if (typeof kakao === 'undefined') return;
  const mapContainer = document.getElementById('companyMap');
  if (!mapContainer) return;
  const mapLocation = {
    x: 37.530733879674145,
    y: 126.89887339311068
  };
  const mapOptions = {
    center: new kakao.maps.LatLng(mapLocation.x, mapLocation.y),
    level: 3
  };
  const map = new kakao.maps.Map(mapContainer, mapOptions);

  const imageSrc = imgsrc; // 마커이미지의 주소
  let imageSize;
  let imageOption;
  if (window.innerWidth < 800) {
    imageSize = new kakao.maps.Size(imgWidth / 2, imgHeight / 2); // 마커이미지의 크기
    imageOption = {
      offset: new kakao.maps.Point(imgWidth / 4, imgHeight / 2)
    };
  } else {
    imageSize = new kakao.maps.Size(imgWidth, imgHeight); // 마커이미지의 크기
    imageOption = {
      offset: new kakao.maps.Point(imgWidth / 2, imgHeight)
    };
  }
  const markerImage = new kakao.maps.MarkerImage(imageSrc, imageSize, imageOption);
  const markerPosition = new kakao.maps.LatLng(mapLocation.x, mapLocation.y);
  const marker = new kakao.maps.Marker({
    position: markerPosition,
    image: markerImage
  });
  marker.setMap(map);
}

// Work
let $tagSwiper;
let $workGrid;
let $tagFilterAry = [];
function workUI() {
  if ($('.tag-menu .swiper-slide').length) {
    $tagSwiper = new Swiper('.tag-menu', {
      slidesPerView: 'auto',
      on: {
        click: function (swiper, event) {
          itemClick(event);
        }
      }
    });
  }

  // init Isotope
  if ($('.work-wrap .grid-item').length) {
    workItemSize();
    $workGrid = $('.work-wrap .grid').isotope({
      layoutMode: 'packery',
      itemSelector: '.grid-item'
    });
    const grid = document.querySelector('.work-wrap .grid');
    imageLoadIsotope($workGrid, grid);
  }

  function itemClick(e) {
    const $this = $(e.target);
    if (!$this.hasClass('tag-item')) return;
    // e.preventDefault();
    const $value = '.' + $this.data('value');
    if ($value === '.all') {
      if ($this.hasClass('on')) return;
      $('.tag-menu .tag-item').removeClass('on');
      $this.addClass('on');
      $tagFilterAry = [];
    } else {
      if ($this.hasClass('on')) {
        $this.removeClass('on');
        if ($value === '.') return;
        let aryIdx = $tagFilterAry.indexOf($value);
        if (aryIdx !== -1) $tagFilterAry.splice(aryIdx, 1);
      } else {
        $this.addClass('on');
        if ($value === '.') return;
        $tagFilterAry.push($value);
      }
      $('.tag-item[data-value="all"]').removeClass('on');
    }
    tagFilterInit($tagFilterAry);
  }

  function tagFilterInit($ary) {
    const filterValue = $ary.length ? $ary.join(', ') : '*';
    $workGrid.isotope({ filter: filterValue });
    workItemSize();
  }
}

function workItemSize() {
  const $none = $('.work-wrap .list-none');
  const $item = $workGrid ? $workGrid.isotope('getFilteredItemElements') : $('.work-wrap .grid-item');
  const $showItem = $item.length;
  $('.work-wrap .grid-item').removeClass('large');
  if ($showItem) {
    if ($none.is(':visible')) $none.hide();
    $.each($item, function (i) {
      const $this = $(this);
      const idx = i % 8;
      if (idx === 3 || idx === 4) $this.addClass('large');
      if ($workGrid) $workGrid.isotope('layout');
    });
  } else {
    if (!$none.is(':visible')) $none.show();
  }
}

// news
let $newsGrid;
function newsUI() {
  if (!$('.news-wrap .grid').length) return;
  $newsGrid = $('.news-wrap .grid').isotope({
    percentPosition: true,
    itemSelector: '.grid-item'
  });
  const grid = document.querySelector('.news-wrap .grid');
  imageLoadIsotope($newsGrid, grid);
}

function imageLoadIsotope(event, wrap) {
  const images = wrap.querySelectorAll('img');
  let loadedCount = 0;

  // 이미지 로드 완료후에 isotope 실행
  function checkAllImagesLoaded() {
    loadedCount++;
    // if (loadedCount === images.length) {
    event.isotope('layout');
    // }
  }
  // 이미지 로드 완료 체크
  images.forEach((image) => {
    if (image.complete) {
      checkAllImagesLoaded();
    } else {
      image.addEventListener('load', checkAllImagesLoaded);
    }
  });
}

/*** util ***/
function wpRedirection(toUrl) {
  if (toUrl) {
    location.href = toUrl;
  } else {
    let $origin = location.origin;
    let $pathname = location.pathname;

    if ($pathname.indexOf('/wp/') >= 0) $pathname = $pathname.replace('/wp/', '/');

    let $pathAry = $pathname.split('/');
    $pathAry = $pathAry.filter((item) => item !== '');

    if ($pathAry.length) {
      if ($pathname.charAt($pathname.length - 1) === '/') $pathname = $pathname.slice(0, -1) + '.php';
      if ($pathAry.length > 1 && $pathname.indexOf('/index') >= 0) $pathname = $pathname.replace('/index', '');
    }

    location.href = $origin + $pathname;
  }
}

function getOffset(element) {
  let $el = element;
  let $elX = 0;
  let $elY = 0;
  let isSticky = false;
  while ($el && !Number.isNaN($el.offsetLeft) && !Number.isNaN($el.offsetTop)) {
    let $style = window.getComputedStyle($el);
    // const $matrix = new WebKitCSSMatrix($style.transform);
    if ($style.position === 'sticky') {
      isSticky = true;
      $el.style.position = 'static';
    }
    $elX += $el.offsetLeft;
    // $elX += $matrix.m41; //translateX
    $elY += $el.offsetTop;
    // $elY += $matrix.m42;  //translateY
    if (isSticky) {
      isSticky = false;
      $el.style.position = '';
      if ($el.getAttribute('style') === '') $el.removeAttribute('style');
    }
    $el = $el.offsetParent;
    if ($el !== null) {
      $style = window.getComputedStyle($el);
      $elX += parseInt($style.borderLeftWidth);
      $elY += parseInt($style.borderTopWidth);
    }
  }
  return { left: $elX, top: $elY };
}

/** memeber **/
function memeberUI() {
  let clickCount = 0;
  let clickTimeout;

  const hiddenMenuBtnWrap = document.querySelector('.hidden-menu-btn');
  let hiddenMenuBtn;
  if (hiddenMenuBtnWrap) hiddenMenuBtn = hiddenMenuBtnWrap.querySelector('button');
  const hiddenMenuWrap = document.querySelector('.hidden-menu-wrap');

  function hiddenMenuOpen() {
    hiddenMenuBtn.classList.add('on');
    if (hiddenMenuWrap) hiddenMenuWrap.classList.add('open');
  }

  function hiddenMenuClose() {
    hiddenMenuBtn.classList.remove('on');
    if (hiddenMenuWrap) hiddenMenuWrap.classList.remove('open');
  }

  function hiddenMenuToggle() {
    if (hiddenMenuBtnWrap) {
      if (hiddenMenuBtnWrap.classList.contains('active')) {
        hiddenMenuBtnWrap.classList.remove('active');
        hiddenMenuClose();
      } else {
        hiddenMenuBtnWrap.classList.add('active');
      }
    }
  }

  function footerLogoClickHandler() {
    clickTimeout = setTimeout(function () {
      clickCount = 0;
    }, 1000);

    clickCount += 1;
    if (clickCount >= 5) {
      hiddenMenuToggle();
      clickCount = 0;
      clearTimeout(clickTimeout);
    }
  }

  function hiddenMenuBtnHandler(e) {
    e.preventDefault();
    if (hiddenMenuBtn.classList.contains('on')) {
      hiddenMenuClose();
    } else {
      hiddenMenuOpen();
    }
  }

  function hiddenMenuCloseHandler(e) {
    const target = e.target;
    if (target.classList.contains('btn-close')) {
      e.preventDefault();
      hiddenMenuBtn.classList.remove('on');
      if (hiddenMenuWrap) hiddenMenuWrap.classList.remove('open');
    }
  }

  const footerLogo = document.querySelector('#footer .logo');
  if (!footerLogo) return;
  footerLogo.addEventListener('click', footerLogoClickHandler);
  if (hiddenMenuBtn) {
    hiddenMenuBtn.addEventListener('click', hiddenMenuBtnHandler);
  }
  if (hiddenMenuWrap) {
    hiddenMenuWrap.addEventListener('click', hiddenMenuCloseHandler);
  }
}

function buttonLoading(element, show) {
  const loadingElClass = '.loading-svg';
  const activeClass = '.loading';
  const $element = $(element);
  if (show === undefined) show = true;
  if (!$element) return;
  const $elW = $element.outerWidth();
  const $elH = $element.outerHeight();
  const $min = $elW < $elH ? $elW / 2 : $elH / 2;
  // const $max = $elW < $elH ? $elH : $elW;
  let $html = '<div class="' + loadingElClass.slice(1) + '" role="img">';
  $html += '<svg width="65px" height="65px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">';
  $html += '<circle class="path" fill="none" stroke-width="6" stroke-linecap="round" cx="33" cy="33" r="30"></circle>';
  $html += '</svg>';
  $html += '</div>';
  if (show) {
    $element.addClass(activeClass.slice(1));
    $element.append($html);
  } else {
    $element.find(loadingElClass).remove();
    $element.removeClass(activeClass.slice(1));
  }
}
