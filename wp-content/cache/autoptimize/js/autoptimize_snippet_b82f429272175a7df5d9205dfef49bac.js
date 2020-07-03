!function(){"use strict";var e,t=()=>window.innerWidth<=960,n=function(e,t){for(var n=0;n<e.length;n++)t(e[n])},r=e=>{var t=e.split("#");return t.length>1?t[0]:e},o=(e,t,n)=>{for(var r=e instanceof NodeList?e:[e],o=0;o<r.length;o++)r[o]&&r[o].addEventListener(t,n)},i=(e,t)=>{l(e,t,"toggle")},a=(e,t)=>{l(e,t,"add")},d=(e,t)=>{l(e,t,"remove")},l=(e,t,n)=>{for(var r=t.split(" "),o=e instanceof NodeList?e:[e],i=0;i<o.length;i++)o[i]&&o[i].classList[n].apply(o[i].classList,r)},s=null,u=null,c=2,v=()=>!("enabled"!==NeveProperties.masonry||NeveProperties.masonryColumns<2)&&(null!==(u=document.querySelector(".nv-index-posts .posts-wrapper"))&&void imagesLoaded(u,()=>{s=new Masonry(u,{itemSelector:"article.layout-grid",columnWidth:"article.layout-grid",percentPosition:!0})})),p=()=>"enabled"===NeveProperties.infiniteScroll&&(null!==document.querySelector(".nv-index-posts .posts-wrapper")&&void function(e,t){var n=arguments.length>2&&void 0!==arguments[2]?arguments[2]:.5,r=new IntersectionObserver(e=>{e[0].intersectionRatio<=n||t()});r.observe(e)}(document.querySelector(".infinite-scroll-trigger"),()=>{if(parent.wp.customize)return parent.wp.customize.requestChangesetUpdate().then(()=>{m()}),!1;m()})),m=()=>{var e=document.querySelector(".infinite-scroll-trigger");if(null===e)return!1;if(document.querySelector(".nv-loader").style.display="block",c>NeveProperties.infiniteScrollMaxPages)return e.parentNode.removeChild(e),document.querySelector(".nv-loader").style.display="none",!1;var t,r,o,i,a=document.querySelector(".nv-index-posts .posts-wrapper"),d=y(NeveProperties.infiniteScrollEndpoint+c);c++,t=d,r=e=>{if("enabled"!==NeveProperties.masonry)a.innerHTML+=JSON.parse(e);else{var t=document.createElement("div");t.innerHTML=JSON.parse(e),n(t.children,e=>{u.append(e),s.appended(e)})}},o=NeveProperties.infiniteScrollQuery,(i=new XMLHttpRequest).onload=()=>{4===i.readyState&&200===i.status&&r(i.response)},i.onerror=e=>{console.error(e)},i.open("POST",t,!0),i.setRequestHeader("Content-Type","application/json; charset=UTF-8"),i.send(o)},y=e=>void 0===wp.customize?e:(e+="?customize_changeset_uuid="+wp.customize.settings.changeset.uuid+"&customize_autosaved=on","undefined"==typeof _wpCustomizeSettings?e:e+="&customize_preview_nonce="+_wpCustomizeSettings.nonce.preview),g=()=>{var o,l;e=window.location.href,h(),function(){var t=document.querySelectorAll(".nv-nav-wrap a");if(0===t.length)return!1;n(t,t=>{t.addEventListener("click",t=>{var n=t.target.getAttribute("href");if(null===n)return!1;r(n)===r(e)&&window.HFG.toggleMenuSidebar(!1)})})}(),o=document.querySelectorAll(".caret-wrap"),n(o,e=>{e.addEventListener("click",t=>{t.preventDefault();var n=e.parentNode.parentNode.querySelector(".sub-menu");i(e,"dropdown-open"),i(n,"dropdown-open")})}),function(){var e=document.querySelectorAll(".nv-nav-search"),r=document.querySelectorAll(".menu-item-nav-search"),o=document.querySelectorAll(".close-responsive-search");document.querySelector("html");n(r,e=>{e.addEventListener("click",n=>{n.stopPropagation(),i(e,"active"),e.querySelector(".search-field").focus(),t()||function(e,t){var n=document.querySelector(".nav-clickaway-overlay");if(null!==n)return!1;n=document.createElement("div"),a(n,"nav-clickaway-overlay");var r=document.querySelector("header.header");r.parentNode.insertBefore(n,r),n.addEventListener("click",()=>{d(e,t),n.parentNode.removeChild(n)})}(e,"active")})}),n(e,e=>{e.addEventListener("click",e=>{e.stopPropagation()})}),n(o,e=>{e.addEventListener("click",e=>{e.preventDefault(),n(r,e=>{d(e,"active")});var t=document.querySelector(".nav-clickaway-overlay");null!==t&&t.parentNode.removeChild(t)})})}(),f(),!0===/(Trident|MSIE|Edge)/.test(window.navigator.userAgent)&&(l=document.querySelectorAll('.header--row[data-show-on="desktop"] .sub-menu'),n(l,e=>{var t=e.parentNode;t.addEventListener("mouseenter",()=>{a(e,"dropdown-open")}),t.addEventListener("mouseleave",()=>{d(e,"dropdown-open")})}))},h=()=>{if(t())return!1;var e=document.querySelectorAll(".sub-menu .sub-menu");if(0===e.length)return!1;var r=window.innerWidth;n(e,e=>{var t=e.getBoundingClientRect(),n=t.left;/webkit.*mobile/i.test(navigator.userAgent)&&(t-=window.scrollX),n+t.width>=r&&(e.style.right="100%",e.style.left="auto")})};function f(){var e=document.querySelectorAll(".header--row .nv-nav-cart");0!==e.length&&n(e,e=>{e.getBoundingClientRect().left<0&&(e.style.left=0)})}window.addEventListener("resize",f);var w,S=function(){this.options={menuToggleDuration:300},this.init()};function b(){window.HFG=new S,(()=>{if(null===document.querySelector(".blog.nv-index-posts"))return!1;v(),p()})(),g()}function q(){h()}S.prototype.init=function(){var e=arguments.length>0&&void 0!==arguments[0]&&arguments[0],t=".menu-mobile-toggle";!1===e&&(t+=", #header-menu-sidebar .close-panel, .close-sidebar-panel");var r=document.querySelectorAll(t),i=function(e){e.preventDefault(),this.toggleMenuSidebar()};n(r,function(e){e.removeEventListener("click",i.bind(this))}.bind(this)),o(r,"click",i.bind(this));var a=document.querySelector(".header-menu-sidebar-overlay");o(a,"click",function(){this.toggleMenuSidebar(!1)}.bind(this))},S.prototype.toggleMenuSidebar=function(e){var t=document.querySelectorAll(".menu-mobile-toggle");d(document.body,"hiding-header-menu-sidebar"),document.body.classList.contains("is-menu-sidebar")||!1===e?(a(document.body,"hiding-header-menu-sidebar"),d(document.body,"is-menu-sidebar"),d(t,"is-active"),setTimeout(function(){d(document.body,"hiding-header-menu-sidebar")}.bind(this),1e3)):(a(document.body,"is-menu-sidebar"),a(t,"is-active"))},window.addEventListener("load",()=>{b()}),window.addEventListener("resize",()=>{clearTimeout(w),w=setTimeout(q,500)})}();