const _Redux = {
  construct() {
    $(() => {
      this.store = __GLOBAL__.get("redux.store");
    });
    return this;
  },
  toggleLoader(loaderState) {
    const storeState = this.store.getState();
    this.store.dispatch({
      type: "data/updateData",
      payload: {
        ...storeState.data,
        loaderStateChange: { state: loaderState },
      },
    });
  },
}.construct();

if ($(".js-coupon-form").length) {
  window.couponCtrl = {
    construct() {
      const form = $(".js-coupon-form");
      const input = form.find("input");
      const revokeBtn = form.find(".js-revoke-btn");
      this.button = form.children("button:not(.js-revoke-btn)");
      this.messageWrap = input.next();
      form.on("submit", (e) => {
        e.preventDefault();
        const couponCode = input.val();
        if (!couponCode) return this.setMessage("کد الزامی است", "danger");
        this.setLoading(true);
        this.hideMessage();
        $.ajax({
          method: "POST",
          url: "/api/coupon",
          data: { code: couponCode },
          success: (data, status, xhr) => {
            this.setMessage(data.message, "success");
            this.setLoading(false);
            this.fetchInfo();
            revokeBtn.show();
          },
          error: async (xhr, status, err) => {
            const error = xhr.responseJSON?.messages?.[0];
            this.setLoading(false);
            error && this.setMessage(error, "danger");
          },
        });
      });
      revokeBtn.on("click", (e) => {
        $.ajax({
          url: `/api/coupon/revoke`,
          success: (data, status, xhr) => {
            input.val("");
            this.hideMessage();
            this.fetchInfo();
            revokeBtn.hide();
          },
          error: async (xhr, status, err) => {
            console.log(err);
          },
        });
      });
      return this;
    },
    fetchInfo() {
      if (location.pathname === "/cart") {
        $.ajax({
          url: `/ajax/cart/info`,
          success: (data, status, xhr) => {
            $(".js-cart-info").replaceWith(data);
          },
          error: async (xhr, status, err) => {
            console.log(err);
          },
        });
      } else {
        $.ajax({
          url: `/ajax/checkout/info`,
          success: (data, status, xhr) => {
            $(".js-checkout-info").replaceWith(data);
          },
          error: async (xhr, status, err) => {
            console.log(err);
          },
        });
      }
    },
    setLoading(isLoading) {
      if (isLoading) {
        this.button.html(
          `<span class="spinner-border spinner-border-sm" style="color:white;"></span>`
        );
      } else {
        this.button.text("اعمال کد تخفیف");
      }
    },
    setMessage(message, level) {
      this.messageWrap
        .removeClass("text-danger text-success")
        .addClass(`text-${level}`)
        .text(message)
        .show();
    },
    hideMessage() {
      this.messageWrap.hide().removeClass("text-danger text-success").empty();
    },
  }.construct();
}
if ($(".js-alert-container").length) {
  window.errorCtrl = {
    construct() {
      const container = $(".js-alert-container");
      this.container = container;
      return this;
    },
    handleErrors(xhr) {
      const errors = xhr.responseJSON?.messages;
      errors && this.showErrors(errors);
    },
    clearErrors() {
      this.container.empty().hide();
    },
    showErrors(errors) {
      errors.forEach((error) =>
        $(`
            <div class="alert alert-danger alert-dismissible fade show mt-3">
                ${error}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>`)
          .appendTo(this.container)
          .alert()
      );
      this.container.show();
      $("body,html").animate({
        scrollTop: 0,
      });
    },
  }.construct();
}
// Alert Container
{
  const alertContainer = $(".js-alert-container");
  if (alertContainer.length) {
    alertContainer.on("closed.bs.alert", ".alert", (e) => {
      const alert = $(e.currentTarget);
      if (alert.siblings().length) {
        alert.remove();
      } else {
        alertContainer.empty().hide();
      }
    });
  }
}
// Pages
// Cart
{
  $(document).on("change", ".js-quantity-input", function (e) {
    e.preventDefault();
    if (e.originalEvent.isTrusted) return;
    const input = $(e.currentTarget);
    const item = input.closest("[data-cart-item-id]");
    _Redux.toggleLoader(true);
    errorCtrl.clearErrors();
    $.ajax({
      method: "POST",
      url: `/ajax/cart/${item.attr("data-cart-item-id")}`,
      data: { _method: "PATCH", quantity: e.originalEvent.detail.value },
      success(data, status, xhr) {
        const newEl = $(data.item_html);
        item.replaceWith(newEl);
        newEl.find(".js-quantity-input").parent().customNumber();
        $(".js-cart-info").replaceWith(data.info_html);
        _Redux.toggleLoader(false);
      },
      error: async (xhr, status, err) => {
        _Redux.toggleLoader(false);
        errorCtrl.handleErrors(xhr);
      },
    });
  });
}
// Compare
{
  // Search
  {
    const wrap = $(".js-compare-search-wrap");
    const input = wrap.find("input");
    const button = wrap.find("button");
    const resultsWrap = wrap.find(".search-result");
    let currentData;
    const handleClickOutside = (e) => {
      if (!resultsWrap[0].contains(e.target)) {
        resultsWrap.hide().empty();
        $(window).off("click", handleClickOutside);
      }
    };
    const handleWrapperScroll = (e) => {
      if (resultsWrap.innerHeight() + resultsWrap.scrollTop() > resultsWrap.prop("scrollHeight")) {
        resultsWrap.off("scroll", handleWrapperScroll);
        const loader = $(
          `<div class="d-flex justify-content-center mt-4"><span class="spinner-border spinner-border-sm"></span></div>`
        ).appendTo(resultsWrap);
        $.ajax({
          url: "/ajax/products/compare",
          data: {
            q: currentData.query,
            page: currentData.next_page,
            ...__DATA.pageData.products.reduce(
              (acc, current, idx) => ((acc[`comparable_products[${idx}]`] = current), acc),
              {}
            ),
          },
          success(data, status, xhr) {
            resultsWrap.children(".row").append(initItems($(data.html)));
            currentData = data.data;
            loader.remove();
            if (data.data.has_next_page) {
              resultsWrap.on("scroll", handleWrapperScroll);
            }
          },
          error: async (xhr, status, err) => {
            console.log(err);
          },
        });
      }
    };
    const initItems = (elements) => {
      return elements.find(".js-compare-add-btn").on("click", (e) => {
        const id = $(e.currentTarget).attr("data-id");
        location.pathname = location.pathname
          .split("/")
          .filter((part) => part !== id)
          .concat(id)
          .join("/");
      });
    };
    // $(".js-compare-remove").on("click", function () {
    //     location.pathname = location.pathname
    //       .split("/")
    //       .filter((part) => part !== $(this).attr("data-id"))
    //       .join("/");
    //   });
    button.on("click", (e) => {
      const value = input.val().trim();
      if (value) {
        setIsSearching(true);
        resultsWrap.hide().empty();
        $.ajax({
          url: "/ajax/products/compare",
          data: { q: value },
          success(data, status, xhr) {
            if (data.data.total_items_count) {
              resultsWrap.html(`<div class="row">${data.html}</div>`).show();
              initItems(resultsWrap.find(".row > *"));
              data.data.query = value;
              currentData = data.data;
              if (data.data.has_next_page) {
                resultsWrap.on("scroll", handleWrapperScroll);
              }
            } else {
              resultsWrap.html("نتیجه ای یافت نشد").show();
            }
            setIsSearching(false);
            $(window).on("click", handleClickOutside);
          },
          error: async (xhr, status, err) => {
            console.log(err);
          },
        });
      }
    });
    function setIsSearching(state) {
      button
        .prop("disabled", state)
        .html(
          state
            ? ` <span class="spinner-border spinner-border-sm"></span>`
            : `<span class="fas fa-search"></span>`
        );
    }
  }
  // Comparable Products
  $(document).on("click", ".js-remove-btn", (e) => {
    const productId = $(e.currentTarget).attr("data-product-id");
    location.pathname = location.pathname
      .split("/")
      .filter((part) => part !== productId)
      .join("/");
  });
}
// Product
{
  let isFetchingComments = false;
  $(".js-show-more").on("click", (e) => {
    const btn = $(e.currentTarget);
    const isActive = btn.toggleClass("active").hasClass("active");
    if (isActive) {
      btn.text("نمایش کمتر");
      $("#tab-specification").find("[data-show-more]").show();
    } else {
      btn.text("نمایش بیشتر");
      window.scrollTo({ top: $("#tab-specification").offset().top });
      $("#tab-specification").find("[data-show-more]").css("display", "");
    }
  });
  const initPagination = () => {
    $(".js-product-comments-pagination").on("click", ".page-link", (e) => {
      e.preventDefault();
      if (isFetchingComments) return;
      isFetchingComments = true;
      const loading = $(".js-product-comments-pagination").find(".js-loading");
      loading.show();
      $.ajax({
        url: $(e.currentTarget).attr("href"),
        success(data, status, xhr) {
          $(".reviews-list").replaceWith(data.html);
          window.scrollTo({ top: $("#tab-reviews").offset().top });
          isFetchingComments = false;
          initPagination();
        },
        error: async (xhr, status, err) => {
          isFetchingComments = false;
          loading.hide();
          console.log(err);
        },
      });
    });
  };
  initPagination();
}
// Users.AddAddress
{
  $(".js-address-form").on("change", "select[name=province]", (e) => {
    const provinceId = $(e.currentTarget).val();
    $.ajax({
      url: `/api/addresses/provinces/${provinceId}/cities`,
      success(data, status, xhr) {
        $(".js-address-form select[name=city]").html(`
                    <option hidden selected value="">انتخاب کنید</option>
                    ${data
                      .map((city) => `<option value="${city.id}">${city.name}</option>`)
                      .join("")}
                `);
      },
      error: async (xhr, status, err) => {
        console.log(err);
      },
    });
  });
}
// Users.EditProfile
{
  $("input[name=profile_image]").on("change", (e) => {
    const file = e.target.files[0];
    if (!file) return;
    const input = $(e.target);
    const form = input.closest("form");
    const fileReader = new FileReader();
    fileReader.onload = (e) => {
      form.find("img").prop("src", e.target.result);
      if (!form.find("button").length) {
        const submitBtn = $(`<button class="btn btn-primary mt-3">ذخیره</button>`);
        form.append(submitBtn);
      }
    };
    fileReader.readAsDataURL(file);
  });
}
// Phone OTP
{
  $(".js-otp-resend-btn")
    .find("[data-resend-countdown]")
    .each(function () {
      $(this).countdown(
        new Date().getTime() + parseInt($(this).attr("data-resend-countdown")) * 1000,
        function (e) {
          $(this)
            .html(e.strftime(`%M:%S`))
            .on("finish.countdown", () =>
              $(this)
                .parent()
                .prop("disabled", false)
                .text("ارسال مجدد")
                .on("click", (e) => {
                  location.pathname = "/profile/phone/resend-otp";
                })
            );
        }
      );
    });
}
