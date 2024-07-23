// Adding custom CSS to the document
const style = document.createElement('style');
style.innerHTML = `
	button, .btn {
		background-color: #102958 !important;
		color: #fff !important; /* Optional: to ensure text color is white */
	}
	#s-c-bn:after, #s-c-bn:before {
		background: #444d53;
		background: #ffffff;
		border-radius: 1em;
		height: .6em;
		left: .82em;
		top: .58em;
		width: 1.5px;
	}
	.cc_div .act .b-bn .exp:before, .cc_div .b-bn .exp:before {
		border: solid #2d4156;
		border-color: #ffffff;
		border-width: 0 2px 2px 0;
		content: "";
		display: inline-block;
		left: 1.2em;
		margin-right: 15px;
		padding: .2em;
		position: absolute;
		top: 50%;
		transform: translateY(-50%) rotate(45deg);
	}
`;
document.head.appendChild(style);

//const config = {}

// let cc = initCookieConsent();
// cc.run(config);
 let cc = initCookieConsent();
 
 /*
gui_options: {
    consent_modal: {
      layout: 'cloud',               // box/cloud/bar
      position: 'bottom center',     // bottom/middle/top + left/right/center
      transition: 'slide',           // zoom/slide
      swap_buttons: false            // enable to invert buttons
    },
    settings_modal: {
      layout: 'box',                 // box/bar
      // position: 'left',           // left/right
      transition: 'slide'            // zoom/slide
    }
  }
 */
 
const config = {
	
    page_scripts: true,                        // default: false
	onFirstAction: function(user_preferences, cookie){
                    // callback triggered only once on the first accept/reject action
  },

  onAccept: function (cookie) {
                    // callback triggered on the first accept/reject action, and after each page load
  },

  onChange: function (cookie, changed_categories) {
                    // callback triggered when user changes preferences after consent has already been given
  },
  
  current_lang: 'en',
  autorun: true,
  autoclear_cookies: true,
  languages: {
    en: {
      consent_modal: {
		
        title: '<p style="font-size:16px; color: #000;" >เว็บไซต์นี้ใช้คุกกี้</p>',
        description:
          '<p style="font-size: 0.8rem; color: #000;">เว็บไซต์นี้ใช้คุกกี้ที่จำเป็นเพื่อให้แน่ใจว่ามีการทำงานที่เหมาะสมและติดตามคุกกี้เพื่อทำความเข้าใจว่าคุณโต้ตอบกับมันอย่างไร ส่วนหลังจะถูกตั้งค่าหลังจากได้รับความยินยอมเท่านั้น <button type="button" data-cc="c-settings" class="cc-link" style="background-color: #fff !important; color: #000 !important;">ตั้งค่าคุกกี้</button> </p>',
        primary_btn: {
          text: '<p style="font-size:14px; text-align:center;">ยอมรับ</p>',
          role: "accept_all", // 'accept_selected' or 'accept_all'
        },
        secondary_btn: {
          text: '<p style="font-size:14px; text-align:center;">ปฏิเสธ</p>',
          role: "accept_necessary", // 'settings' or 'accept_necessary'
        },
      },
      settings_modal: {
        title: '<p style="font-size:16px; color: #000; text-align:left;">ตั้งค่าคุกกี้</p>',
        save_settings_btn: '<p style="font-size:14px; text-align:center;">บันทึกการตั้งค่า</p>',
        accept_all_btn: '<p style="font-size:14px; text-align:center;">ยอมรับทั้งหมด</p>',
        reject_all_btn: '<p style="font-size:14px; text-align:center;">ปฏิเสธทั้งหมด</p>',
        close_btn_label: "Close",
        cookie_table_headers: [

        ],
        blocks: [
          {
            title: '<p style="font-size:16px; color: #000; text-align:center;text-align:left;">การใช้คุกกี้ 📢</p>',
            description:
              '<p style="font-size:0.8rem; color: #000; text-align:left;">ใช้คุกกี้เพื่อให้แน่ใจว่าฟังก์ชันพื้นฐานของเว็บไซต์และเพื่อปรับปรุงประสบการณ์ออนไลน์ของคุณ คุณสามารถเลือกเข้าร่วม/ไม่เข้าร่วมสำหรับแต่ละหมวดหมู่ได้ทุกเมื่อที่คุณต้องการ สำหรับรายละเอียดเพิ่มเติมเกี่ยวกับคุกกี้และข้อมูลที่ละเอียดอ่อนอื่น ๆ โปรดอ่านฉบับเต็ม <a href="https://smartbooking.installdirect.asia/Cookiepolicy" class="cc-link">นโยบายการใช้คุกกี้ </a></p>',
          },
          {
            title: '<p style="font-size:14px; text-align:left;">คุกกี้ที่จำเป็น</p>',
            description:
              '<p style="font-size:14px; color: #000; text-align:left;">คุกกี้เหล่านี้จำเป็นต่อการทำงานที่เหมาะสมของเว็บไซต์ หากไม่มีคุกกี้เหล่านี้ เว็บไซต์ก็จะทำงานไม่ถูกต้อง</p>',
            toggle: {
              value: "necessary",
              enabled: true,
              readonly: true, // cookie categories with readonly=true are all treated as "necessary cookies"
            },
          },
          {
            title: '<p style="font-size:14px; text-align:left;">คุกกี้เพื่อการวิเคราะห์และประเมินผลใช้งาน</p>',
            description:
              '<p style="font-size:14px; color: #000; text-align:left;">สามารถนับจำนวนผู้เข้าชมเว็บไซต์ และแหล่งที่มาของผู้เข้าชมเหล่านั้น ทำให้เข้าใจว่าผู้เข้าชม/ผู้ใช้มีการปฏิสัมพันธ์กับเว็บไซต์อย่างไรบ้าง และหน้าเว็บใดที่ได้รับความนิยมมากที่สุดหรือน้อยที่สุด โดยการเก็บรวบรวมและการรายงานข้อมูลโดยไม่ระบุตัวตนของท่านอย่างไม่เฉพาะเจาะจง</p>',
            toggle: {
              value: "analytics", // your cookie category
              enabled: false,
              readonly: false,
            },
            cookie_table: [
              // list of all expected cookies
              
            ],
          },
          {
            title: '<p style="font-size:14px; text-align:left;">คุกกี้การโฆษณาและการกำหนดเป้าหมาย</p>',
            description:
              '<p style="font-size:14px; color: #000; text-align:left;">คุกกี้ประเภทนี้จะทำการจัดเก็บข้อมูลการเข้าชมเว็บไซต์ของท่านว่า ท่านเข้าชมเว็บไซต์ใดบ้าง และเข้าชมเว็บไซต์ผ่านทางลิ้งก์ใดบ้าง</p>',
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
