let scrollInstance = {
  position: 0,
  direction: null,
  offset: 10
};

let speechObjects = {};
let currentSpeechObjectIndex = 0;
let voices = false;
let disabledHeaderScrollTimeout = false;

import EasySpeech from './easySpeech.js';

jQuery(document).ready(function () {
  startOwlSlider();
  setHamburgerOnClick();
  wrapIframe();
  replaceImgWithSvg();
  setAlignInATag();
  setOnSearch();
  setLogoSlider();
  setSponsorSlider();
  setOnReadAloutListener();
  setOnRecordView();
  setOnSidebarItemClick();
  setOnFAQListener();
  setOnTabListener();
  countUpValues();
  EasySpeech.init({ maxTimeout: 5000, interval: 250 })
    // we speak 
    .then(function () {
      voices = EasySpeech.voices().filter((element) => element.lang == 'nl-NL');
    })
});

jQuery(window).on('scroll', function () {
  if (jQuery('header').hasClass('is-scroll-disabled')) return;

  setOnHeaderClass();
  setScrollInstance();
  setHeaderScrollInstanceClass();
  setOnNavigationControl();
});

jQuery(window).on('beforeunload', function () {
  clearSpeechObjects();
});

jQuery(window).on('load', function () {
  setMasonryGrid();

})

// functions
function setSponsorSlider() {
  jQuery('.sponsor-slider').owlCarousel({
    items: 1,
    nav: false,
    dots: false,
    loop: true,
    responsive: {
      768: {
        items: 2,
      },
      992: {
        items: 3
      },
      1199: {
        items: 4,
      }

    }
  });
}

function countUpValues() {
  inView('.count')
    .on('enter', function (element) {
      var $this = jQuery(element),
        value = numeral($this.text());

      if ($this.hasClass('doing') || $this.hasClass('done')) return;

      // add doing class
      $this.addClass('doing');

      jQuery({ Counter: 0 }).animate({ Counter: $this.text() }, {
        duration: 1500,
        easing: 'swing',
        step: function () {
          $this.text(Math.ceil(this.Counter));
        },
        complete: function () {
          var formattedValue = value.format('0,0');

          // we replace the value , to .
          while (formattedValue.indexOf(",") > -1)
            formattedValue = formattedValue.replace(",", ".");

          // set the text
          $this.text(formattedValue);

          // remove doing
          $this.removeClass('doing');

          // add done
          $this.addClass('done');
        }
      });
    });
}

function setMasonryGrid() {
  jQuery('.masonry-items .items').masonry({
    itemSelector: '.item',
    gutter: 25
  });
}

function setOnTabListener() {
  jQuery('.tabs button').on('click', function (e) {
    let container = jQuery(this).parents('.tabs-section');
    let index = jQuery(this).index();

    // switch state for current button
    container.find('.tabs button').removeClass('is-active');
    jQuery(this).addClass('is-active');

    container.find('.tab-content').removeClass('is-active');
    container.find('.tab-content').eq(index).addClass('is-active');
  });
}

function setOnFAQListener() {
  jQuery('.faq-item').on('click', function () {
    if (jQuery(this).hasClass('is-active')) return;
    // disable the header scroll functionality.
    disableHeaderScroll();
    // remove the class from all the other items
    jQuery('.faq-item').removeClass('is-active');
    jQuery('.faq-item .faq-content').not(this).stop().slideUp();
    // add the class to the current one.
    jQuery(this).addClass('is-active').find('.faq-content').slideDown();
  });
}

function disableHeaderScroll() {
  jQuery('header').addClass('is-scroll-disabled');

  clearTimeout(disabledHeaderScrollTimeout);

  disabledHeaderScrollTimeout = setTimeout(function () {
    jQuery('header').removeClass('is-scroll-disabled');
  }, 1000)
}

function clearSpeechObjects() {
  for (let key in speechObjects) {
    speechObjects[key].stop()
  }

  speechObjects = {};
  currentSpeechObjectIndex = 0;
}

function setOnReadAloutListener() {
  jQuery(".readout .btn").on("click", function () {
    // we clear the previous speeches
    let elements = jQuery('.page-content .content, .items .item').children();
    jQuery(this).parent().removeClass('is-playing is-paused');
    jQuery(this).parent().addClass('is-speaking is-playing');

    clearSpeechObjects();

    elements.each(function (i, e) {
      speechObjects[`item-${i}`] = {
        element: jQuery(e),
        speech: new SpeechSynthesisUtterance(jQuery(this).text()),
        original: jQuery(e).html(),
        play: function () {
          return speechSynthesis.speak(this.speech);
        },
        stop: function () {
          return speechSynthesis.cancel();
        },
        pause: function () {
          return speechSynthesis.pause();
        },
        resume: function () {
          return speechSynthesis.resume();
        }
      };

      speechObjects[`item-${i}`].speech.lang = voices[0];
      speechObjects[`item-${i}`].speech.text = jQuery(this).text();
      speechObjects[`item-${i}`].speech.rate = 1;
      speechObjects[`item-${i}`].speech.volume = 1;

      speechObjects[`item-${i}`].speech.onboundary = function (event) {
        let startPosition = event.charIndex;
        let endPosition = startPosition + event.charLength;

        if (startPosition == endPosition) return;

        let textArray = speechObjects[`item-${i}`].element.text().split('');

        jQuery('.highlight').removeClass('do-highlight');

        textArray[startPosition] = `<span class='highlight do-highlight'>${textArray[startPosition]}`;
        textArray[endPosition] = `</span>${textArray[endPosition] != undefined ? textArray[endPosition] : ''}`;

        speechObjects[`item-${i}`].element.html(textArray.join(""));
      }

      speechObjects[`item-${i}`].speech.onerror = function (event) {
      }

      // we clear the readable thing.
      speechObjects[`item-${i}`].speech.onend = function (event) {
        // we increment the current index.
        currentSpeechObjectIndex = currentSpeechObjectIndex + 1;

        // we remove the highlight
        speechObjects[`item-${i}`].element.removeClass('is-reading');

        // we set back the original html
        speechObjects[`item-${i}`].element.html(speechObjects[`item-${i}`].original);

        // play the next one.
        if (jQuery('.is-speaking').length > 0)
          speechObjects[`item-${currentSpeechObjectIndex}`].play();
      }

      // we hightligh the readable thing.
      speechObjects[`item-${i}`].speech.onstart = function (event) {
        // we remove the highlight
        speechObjects[`item-${i}`].element.addClass('is-reading');

        jQuery('html, body').stop().animate({ scrollTop: speechObjects[`item-${i}`].element.offset().top - 250 });
      }
    });

    // we play the first one.
    speechObjects[`item-${currentSpeechObjectIndex}`].play();
  });

  jQuery('.shortcut-buttons [data-action]').on('click', function (e) {
    let action = jQuery(this).data('action');

    if (action === 'pause') {
      jQuery('.is-speaking').removeClass('is-playing').addClass('is-paused');
      speechObjects[`item-${currentSpeechObjectIndex}`].pause();
      return;
    }

    if (action === 'resume') {
      jQuery('.is-speaking').removeClass('is-paused').addClass('is-playing');

      speechObjects[`item-${currentSpeechObjectIndex}`].resume();
      return;
    }

    if (action === 'stop') {
      jQuery('.is-speaking').removeClass("is-speaking");
      speechObjects[`item-${currentSpeechObjectIndex}`].stop();
      return;
    }
  })
}

function setOnNavigationControl() {
  if (jQuery('.sidebar').length == 0) return;
  let currentScrollTop = jQuery(window).scrollTop();
  let positionOfToC = jQuery('.sidebar').offset().top;
  let maxOffset = jQuery('.sidebar').outerHeight() + positionOfToC - jQuery('.sidebar .sidebar-item').outerHeight();
  let ToCSpacing = 25; // the space of the header and the scrollable header.
  let headerHeight = jQuery('header .logo').outerHeight();
  let targetScrollTop = currentScrollTop + headerHeight;

  // we don't have to scroll at this position.
  if (targetScrollTop < positionOfToC) {
    jQuery('.sidebar .sidebar-item').css({ position: 'relative', top: 0 });

    return;
  }

  // we check if we have reached our maximum height.
  if (targetScrollTop > maxOffset) {
    jQuery('.sidebar .sidebar-item').css({ position: 'relative', top: maxOffset - positionOfToC + ToCSpacing });

    return;
  }

  jQuery('.sidebar .sidebar-item').css({ position: 'relative', top: targetScrollTop - positionOfToC + ToCSpacing });
}

function setLogoSlider() {
  jQuery('.logo-slider').owlCarousel({
    items: 1,
    nav: false,
    dots: false,
    loop: true,
    responsive: {
      768: {
        items: 2,
      },
      992: {
        items: 3
      },
      1199: {
        items: 4,
      }

    }
  });
}

function setHeaderScrollInstanceClass() {

  if (scrollInstance.direction == "UP") {
    // remove old class
    jQuery('header')
      .removeClass('scrolling-down')
      .addClass('scrolling-up');
    return;
  }

  // remove old class
  jQuery('header')
    .addClass('scrolling-down')
    .removeClass('scrolling-up');
}

function setScrollInstance() {
  if (jQuery(window).scrollTop() > scrollInstance.position) {
    scrollInstance.direction = "DOWN";
  } else {
    scrollInstance.direction = "UP";
  }

  scrollInstance.position = jQuery(window).scrollTop();
}

function wrapIframe() {
  jQuery(".page-content iframe").wrap("<div class='embed-container'></div>");
}

function setOnSearch() {
  jQuery('.launch-search, .btn-search-close').on('click', function (e) {
    e.preventDefault();

    jQuery('.search-screen').toggleClass('active');
  });
}

function setOnHeaderClass() {
  var togglePosition = 10;
  var currentPosition = jQuery(window).scrollTop();
  if (currentPosition > togglePosition) {
    jQuery("header").addClass('scrolled');
    jQuery("main").addClass('scrolled');
  } else {
    jQuery("header").removeClass('scrolled');
    jQuery("main").removeClass('scrolled');
  }
}

function startOwlSlider() {
  jQuery('section.slider').owlCarousel({
    items: 1,
    nav: false,
    dots: false,
  });
}

function replaceImgWithSvg() {
  jQuery('img.svg').each(function () {
    var $img = jQuery(this);
    var imgID = $img.attr('id');
    var imgClass = $img.attr('class');
    var imgURL = $img.attr('src');
    jQuery.get(imgURL, function (data) {
      var $svg = jQuery(data).find('svg');
      if (typeof imgID !== 'undefined') {
        $svg = $svg.attr('id', imgID);
      }
      if (typeof imgClass !== 'undefined') {
        $svg = $svg.attr('class', imgClass + ' replaced-svg');
      }
      $svg = $svg.removeAttr('xmlns:a');
      if (!$svg.attr('viewBox') && $svg.attr('height') && $svg.attr('width')) {
        $svg.attr('viewBox', '0 0 ' + $svg.attr('height') + ' ' + $svg.attr('width'))
      }
      $img.replaceWith($svg);

    }, 'xml');

  });
}

function setHamburgerOnClick() {
  jQuery('.hamburger').on("click", function () {
    jQuery(this).toggleClass('is-active');
    jQuery('.header .menu-primary-container').toggleClass("is-active");
    jQuery('html').toggleClass("is-active");
  });
}

function setAlignInATag() {
  jQuery('img[class*=align]').each(function (i, e) {
    jQuery(e).parents('a').addClass(jQuery(e).attr('class'));
  });
}

function setOnSidebarItemClick() {
  jQuery('.sidebar-item ul li').on('click', function (e) {
    let index = jQuery(this).index('li');
    let text = jQuery(this).text().trim().toLowerCase();
    let item = false;

    jQuery('.page-content .content h2').each(function () {
      if (text == jQuery(this).text().trim().toLowerCase()) {
        item = jQuery(this);
      }
    })

    jQuery('html, body').stop().animate({ scrollTop: item.offset().top - 250 }, 500);
  });
}

function setOnRecordView() {
  inView('h2')
    .on('enter', function (element) {
      let index = jQuery(element).index('h2');

      jQuery('.sidebar-item ul li').eq(index).addClass('in-view');
    })
    .on('exit', function (element) {
      let index = jQuery(element).index('h2');

      jQuery('.sidebar-item ul li').eq(index).removeClass('in-view');
    });;
}

function _fetch(options) {
  return jQuery.ajax({
    url: ajaxurl,
    dataType: 'json',
    data: options,
    method: "POST"
  });
}