//const config = {}

// let cc = initCookieConsent();
// cc.run(config);
 let cc = initCookieConsent();
const config = {
  current_lang: "th",
  autorun: true,
  autoclear_cookies: true,
  languages: {
    en: {
      consent_modal: {
        title: '<p style="font-size:16px;font-family:manrope;">This website uses cookies</p>',
        description:
          '<p style="font-family:manrope;">this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it. The latter will be set only after consent. <button type="button" data-cc="c-settings" class="cc-link">Cookie settings</button></p>',
        primary_btn: {
          text: '<p style="font-family:manrope;text-align:center;">Accept</p>',
          role: "accept_all", // 'accept_selected' or 'accept_all'
        },
        secondary_btn: {
          text: '<p style="font-family:manrope;text-align:center;">Reject</p>',
          role: "accept_necessary", // 'settings' or 'accept_necessary'
        },
      },
      settings_modal: {
        title: '<p style="font-size:20px;font-family:manrope;text-align:left;">Cookie settings</p>',
		save_settings_btn: '<p style="font-family:manrope;text-align:center;">Save settings</p>',
        accept_all_btn: '<p style="font-family:manrope;text-align:center;">Accept all</p>',
        reject_all_btn: '<p style="font-family:manrope;text-align:center;">Reject all</p>',
        close_btn_label: "Close",
        cookie_table_headers: [
          { col1: "Name" },
          { col2: "Domain" },
          { col3: "Expiration" },
          { col4: "Description" },
        ],
        blocks: [
          {
            title: '<p style="font-size:18px;font-family:manrope;text-align:left;">Necessary cookies 📢</p>',
            description:
              '<p style="font-family:manrope;text-align:left;">Cookies to ensure the basic functionalities of the website and to enhance your online experience. You can choose for each category to opt-in/out whenever you want. For more details relative to cookies and other sensitive data, please read the full <a href="../en/cookie-policy.php" class="cc-link">cookie policy</a>.</p>',
          },
          {
            title: '<p style="font-family:manrope;text-align:left;">Strictly necessary cookies</p>',
            description:
              '<p style="font-family:manrope;text-align:left;">These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly</p>',
            toggle: {
              value: "necessary",
              enabled: true,
              readonly: true, // cookie categories with readonly=true are all treated as "necessary cookies"
            },
          },
          {
            title: '<p style="font-family:manrope;text-align:left;">Cookies for analysis and evaluation</p>',
            description:
              '<p style="font-family:manrope;text-align:left;">Performance cookies allow us to count visits and traffic sources so we can measure and improve the performance of our site. They enable us to understand how the Viewer/User interact with the Website by collecting and reporting information anonymously and to help us improve user experience of the Website.</p>',
            toggle: {
              value: "analytics", // your cookie category
              enabled: false,
              readonly: false,
            },
            
          },
          {
            title: '<p style="font-family:manrope;text-align:left;">Advertisement and Targeting cookies</p>',
            description:
              '<p style="font-family:manrope;text-align:left;">This type of cookie stores information about your visit to the website. What websites do you visit? And visit the website through which links?</p>',
            toggle: {
              value: "targeting",
              enabled: false,
              readonly: false,
            },
          },
        ],
      },
    },
  },
};

 cc.run(config);
