;(function(window) {

var svgSprite = '<svg>' +
  ''+
    '<symbol id="icon-ios" viewBox="0 0 1024 1024">'+
      ''+
      '<path d="M788.968805 543.102949a220.42931 220.42931 0 0 1 114.635695-193.093584C855.844816 281.825722 771.845059 244.091213 713.562055 244.091213c-70.176224 0-166.816418 49.005047-194.899361 49.005047-29.826452 0-92.281423-44.334935-175.471694-45.51803-68.681788-0.934022-184.189237 38.543995-224.539009 155.732685-40.349772 117.126421-38.481727 286.433566 46.016176 443.722955 67.747765 125.968501 127.649742 176.96613 185.559136 176.96613 58.033931 0 126.34211-43.774521 180.826756-43.774521 54.360109 0 105.29547 43.774521 161.523624 43.774521 56.103618 0 114.013013-45.580298 156.106294-108.471146 42.093281-63.015385 80.82408-160.900943 80.82408-160.900943l0.747218-6.289085a220.117969 220.117969 0 0 1-141.28647-205.235877z m-123.913651-379.835816c57.162177-65.817452 51.993919-163.267133 51.993919-163.267133S619.474856 8.966616 562.374947 74.846336c-57.162177 65.755184-51.993919 163.329401-51.993919 163.329401s97.574217-9.028884 154.674126-74.908604z" fill="#303440" ></path>'+
      ''+
    '</symbol>'+
  ''+
    '<symbol id="icon-andriod" viewBox="0 0 1024 1024">'+
      ''+
      '<path d="M874.086 693.658h-11.468c-28.468 0-52.02-31.744-52.02-70.656V396.698c0-38.912 23.348-70.656 52.02-70.656h11.468c28.672 0 52.02 31.744 52.02 70.656v226.304c-0.205 38.912-23.552 70.656-52.02 70.656zM721.51 824.32h-43.827v129.024c0 38.707-23.347 70.656-52.019 70.656h-11.469c-28.672 0-52.019-31.744-52.019-70.656V824.32h-97.69v127.59c0 38.708-23.347 70.452-52.019 70.452h-11.469c-28.672 0-52.019-31.744-52.019-70.452V824.32h-47.718c-29.287 0-53.043-25.395-53.043-56.32V321.331h526.336V768c0 30.925-23.962 56.32-53.044 56.32zM388.71 87.45l-47.923-73.728c-2.048-3.277-1.433-7.988 1.843-10.24l1.23-0.82c3.071-2.252 7.372-1.433 9.625 1.844l49.561 76.185c32.564-14.131 68.608-21.913 106.496-21.913 39.936 0 77.824 8.601 111.616 24.37l51.815-79.871c2.253-3.277 6.553-4.096 9.625-1.843l1.23 0.819c3.071 2.253 3.89 6.963 1.842 10.24l-50.38 77.619c72.704 38.912 124.928 110.387 135.577 194.56H248.013c11.059-86.22 65.331-159.13 140.697-197.222z m235.316 113.664c14.336 0 26.01-12.288 26.01-27.648 0-15.156-11.674-27.648-26.01-27.648-14.336 0-26.01 12.288-26.01 27.648s11.674 27.648 26.01 27.648z m-224.666 0c14.336 0 26.01-12.288 26.01-27.648 0-15.156-11.674-27.648-26.01-27.648-14.336 0-26.01 12.288-26.01 27.648s11.47 27.648 26.01 27.648z m-239.616 491.11h-11.469c-28.672 0-52.019-31.744-52.019-70.451V395.264c0-38.707 23.347-70.656 52.02-70.656h11.468c28.672 0 52.02 31.744 52.02 70.656v226.304c0 38.912-23.348 70.656-52.02 70.656z" fill="#333333" ></path>'+
      ''+
    '</symbol>'+
  ''+
'</svg>'
var script = function() {
    var scripts = document.getElementsByTagName('script')
    return scripts[scripts.length - 1]
  }()
var shouldInjectCss = script.getAttribute("data-injectcss")

/**
 * document ready
 */
var ready = function(fn){
  if(document.addEventListener){
      document.addEventListener("DOMContentLoaded",function(){
          document.removeEventListener("DOMContentLoaded",arguments.callee,false)
          fn()
      },false)
  }else if(document.attachEvent){
     IEContentLoaded (window, fn)
  }

  function IEContentLoaded (w, fn) {
      var d = w.document, done = false,
      // only fire once
      init = function () {
          if (!done) {
              done = true
              fn()
          }
      }
      // polling for no errors
      ;(function () {
          try {
              // throws errors until after ondocumentready
              d.documentElement.doScroll('left')
          } catch (e) {
              setTimeout(arguments.callee, 50)
              return
          }
          // no errors, fire

          init()
      })()
      // trying to always fire before onload
      d.onreadystatechange = function() {
          if (d.readyState == 'complete') {
              d.onreadystatechange = null
              init()
          }
      }
  }
}

/**
 * Insert el before target
 *
 * @param {Element} el
 * @param {Element} target
 */

var before = function (el, target) {
  target.parentNode.insertBefore(el, target)
}

/**
 * Prepend el to target
 *
 * @param {Element} el
 * @param {Element} target
 */

var prepend = function (el, target) {
  if (target.firstChild) {
    before(el, target.firstChild)
  } else {
    target.appendChild(el)
  }
}

function appendSvg(){
  var div,svg

  div = document.createElement('div')
  div.innerHTML = svgSprite
  svg = div.getElementsByTagName('svg')[0]
  if (svg) {
    svg.setAttribute('aria-hidden', 'true')
    svg.style.position = 'absolute'
    svg.style.width = 0
    svg.style.height = 0
    svg.style.overflow = 'hidden'
    prepend(svg,document.body)
  }
}

if(shouldInjectCss && !window.__iconfont__svg__cssinject__){
  window.__iconfont__svg__cssinject__ = true
  try{
    document.write("<style>.svgfont {display: inline-block;width: 1em;height: 1em;fill: currentColor;vertical-align: -0.1em;font-size:16px;}</style>");
  }catch(e){
    console && console.log(e)
  }
}

ready(appendSvg)


})(window)
