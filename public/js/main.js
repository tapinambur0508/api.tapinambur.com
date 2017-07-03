const ARTICLE_MASK = "select-article-";
const NEWS_ITEM = $(".news-item-template").html();

$(document).ready(function() {
  getCountArticleInCart();

  $(window).scroll(function() {
    let scrolled = window.pageYOffset;

    if (scrolled > 200) {
      $("header, header .dropdown-menu").css("background-color", "rgba(255, 250, 250, 0.8)");
    } else {
      $("header, header .dropdown-menu").css("background-color", "rgba(255, 250, 250, 1)");
    }

    if (scrolled > 600) {
      $("#up").show();
    } else {
      $("#up").hide();
    }
  });

  $("#up").click(function() {
    let scroll = window.pageYOffset;

    let timerId = setInterval(function() {
      $(document).scrollTop(scroll);
      scroll -= 90;

      if (scroll < 0) {
        clearInterval(timerId);
        window.scrollTo(0, 0);
      }
    }, 10);
  });

  $("button.btn-facebook").click(function() {
    FB.login(function(response) {
      if (response.authResponse) {
        FB.api('/me', function(response) {
          document.cookie = `name=${response.name}; path=/`;
          document.cookie = `social_id=${response.id}; path=/`;
          location.reload();
        });
      } else {
        console.log('User cancelled login or did not fully authorize.');
      }
    });
  });

  $("a[name=btn-exit]").click(function() {
    document.cookie = "name=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.cookie = "social_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    location.href = "/";
  });
});

function isInLocalStorage(id) {
  return localStorage.getItem(`${ARTICLE_MASK}${id}`) == null ? false : true;
}

function getCountArticleInCart() {
  let countArticleInCart = 0;
  $cartCircle = $(".cart .circle");

  for (let i = 0; i < localStorage.length; ++i) {
    if (localStorage.key(i).indexOf(ARTICLE_MASK) != -1) {
      ++countArticleInCart;
    }
  }

  if (countArticleInCart) {
    $cartCircle.text(countArticleInCart);
    $cartCircle.show();
  } else {
    $cartCircle.hide();
  }

  return countArticleInCart;
}

function setToLocalStorage(data) {
  if (isInLocalStorage(data.id)) {
    localStorage.removeItem(`${ARTICLE_MASK}${data.id}`);
  } else {
    localStorage.setItem(`${ARTICLE_MASK}${data.id}`, JSON.stringify(data));
  }

  getCountArticleInCart();
}

function getArticleFromLocalStorage() {
  for (let i = 0; i < localStorage.length; ++i) {
    if (localStorage.key(i).indexOf(ARTICLE_MASK) != -1) {
      try {
        pasteToCart(JSON.parse(localStorage.getItem(localStorage.key(i))));
      } catch (error) {
          console.log(error);
      }
    }
  }
}

function getNews(pos, count, href) {
  $.ajax({
    url: '/public/php/get-news.php',
    type: 'POST',
    data: {
      pos,
      count,
      href
    },
    success: function(data) {
      try {
        data = JSON.parse(data);

        $.each(data, function(index, data) {
          pasteToNews(data);
        });
      } catch (error) {
          console.log(error);
      }
    }
  });
}

function getReadMoreNews(id, count) {
  $.ajax({
    url: '/public/php/get-read-more-news.php',
    type: 'POST',
    data: {
      id,
      count
    },
    success: function(data) {
      try {
        data = JSON.parse(data);

        $.each(data, function(index, data) {
          pasteToNews(data);
        });
      } catch (error) {
          console.log(error);
      }
    }
  });
}

function pasteToNews(data) {
  let newsItem = $(NEWS_ITEM);

  newsItem.find(".image a").attr("href", `/article/${translit(data.header)}/${data.id}/`);
  newsItem.find(".image a img").attr("src", data.cover_image);
  newsItem.find(".image p.date").text(data.date);
  newsItem.find(".image p.views").append(data.views);
  newsItem.find("h2 a").attr("href", `/article/${translit(data.header)}/${data.id}/`);
  newsItem.find("h2 a").text(data.header);
  newsItem.find("h2 + p").text(data.content);

  if (isInLocalStorage(data.id)) {
    newsItem.find("button[name='add-to-cart']").hide();
    newsItem.find("button[name='remove-from-cart']").show();
  } else {
    newsItem.find("button[name='remove-from-cart']").hide();
    newsItem.find("button[name='add-to-cart']").show();
  }

  newsItem.find("button[name='add-to-cart']").click(function() {
    setToLocalStorage(data);
    newsItem.find("button[name='add-to-cart']").hide();
    newsItem.find("button[name='remove-from-cart']").show();
  });

  newsItem.find("button[name='remove-from-cart']").click(function() {
    setToLocalStorage(data);
    newsItem.find("button[name='remove-from-cart']").hide();
    newsItem.find("button[name='add-to-cart']").show();
  });

  salvattore.appendElements(document.querySelector('.masonry'), newsItem);
}

function pasteToCart(data) {
  let newsItem = $(NEWS_ITEM);

  newsItem.find(".image a").attr("href", `/article/${translit(data.header)}/${data.id}/`);
  newsItem.find(".image a img").attr("src", `${data.cover_image}`);
  newsItem.find(".image p.date").text(data.date);
  newsItem.find(".image p.views").append(data.views);
  newsItem.find("h2 a").attr("href", `/article/${translit(data.header)}/${data.id}/`);
  newsItem.find("h2 a").text(data.header);
  newsItem.find("h2 + p").text(data.content);

  newsItem.find("button[name='remove-from-cart']").click(function() {
    newsItem.remove();
    setToLocalStorage(data);

    if (getCountArticleInCart() == 0) {
      $(".cart-panel").hide();
      $("#myContainer").append("<p>Ваш кошик поки що порожній</p>");
    }
  });

  salvattore.appendElements(document.querySelectorAll('.masonry')[1], newsItem);
}

function generateKey() {
  let key = '';

  for (let i = 0; i < localStorage.length; ++i) {
    if (localStorage.key(i).indexOf(ARTICLE_MASK) != -1) {
      try {
        key += `${JSON.parse(localStorage.getItem(localStorage.key(i))).id}&`;
      } catch (error) {
          console.log(error);
      }
    }
  }

  return key.substr(0, (key.length - 1));
}

function clearLocalStorage() {
  for (let i = 0; i < localStorage.length; ++i) {
    if (localStorage.key(i).indexOf(ARTICLE_MASK) != -1) {
      localStorage.removeItem(localStorage.key(i));
    }
  }

  if (getCountArticleInCart()) {
    clearLocalStorage();
  }
}

function checkContent(originContent, content, delta) {
  const reg = /^\s+|\s+$/g;
  originContent = originContent.replace(reg, '').split(' ');
  сontent = content.replace(reg, '').split(' ');

  return originContent.length <= (content.length + delta) ? true : false;
}

function translit(insert) {
  let replase = {
    'а': 'a',
    'б': 'b',
    'в': 'v',
    'г': 'h',
    'ґ': 'g',
    'д': 'd',
    'е': 'e',
    'є': 'ie',
    'ж': 'zh',
    'з': 'z',
    'и': 'y',
    'і': 'i',
    'ї': 'yi',
    'й': 'i',
    'к': 'k',
    'л': 'l',
    'м': 'm',
    'н': 'n',
    'о': 'o',
    'п': 'p',
    'р': 'r',
    'с': 's',
    'т': 't',
    'у': 'u',
    'ф': 'f',
    'х': 'kh',
    'ц': 'c',
    'ч': 'ch',
    'ш': 'sh',
    'щ': 'shch',
    'ъ': 'j',
    'ь': '’',
    'ю': 'iu',
    'я': 'ya',
    ' ': '-',
    ' - ': '-',
    '_': '-',
    '.': '',
    ':': '',
    ';': '',
    ',': '',
    '!': '',
    '?': '',
    '>': '',
    '<': '',
    '&': '',
    '*': '',
    '%': '',
    '$': '',
    '"': '',
    '\'': '',
    '(': '',
    ')': '',
    '`': '',
    '+': '',
    '/': '',
    '\\': ''
  };

  return insert.toLowerCase().replace(/[А-яіІїЇєЄ\s\W]/g, function(a, b) {
    return replase[a] || "";
  });
}
