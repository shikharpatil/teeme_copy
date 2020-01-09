/**
 * === PDFAPI HTML5 JS  ===
 * Contributors for this file: UlmDesign - Francesco De Stefano
 * Tags: html5, pdf, hybrid apps, API filesystem, JavaScript, PDF Web Applications
 * Release: 2.0.1 - 2015 UlmDesign - http://mediamaster.eu
 * License: GPL 3.0 or later 
 * License: URI: http://www.gnu.org/copyleft/gpl.html
 * Description: Export image, html, text, canvas and svg in pdf and in others formats for Web Apps
 * This mini library should necessarily include: 
 * - Download jsdpdf.debug.js from https://github.com/MrRio/jsPDF 
 * - Download canvg project from https://code.google.com/p/canvg/
 * - Download html2canvas project from http://html2canvas.hertzen.com/
 * 
 * */
// library fn
var pdfapihtml5 = {};

pdfapihtml5.fnhtmlPdf = function(sel, mtop, mbottom, mleft, w) {
   var docpdf = new jsPDF('p', 'pt', 'letter'),
        source = document.getElementById(sel),
        specialElementHandlers = {
            '#bypassme': function (element, renderer) {
                return true;
            }
        };
    margins = {
        top: mtop,
        bottom: mbottom,
        left: mleft,
        width: w
    };
    docpdf.fromHTML(
    source, margins.left, margins.top, {
        'width': margins.width,
        'elementHandlers': specialElementHandlers,
        'pagesplit': true
    },

    function (dispose) {
        try {
            var inputFilename = prompt('Enter file name to convert and to save file in pdf in your external storage');
            if (inputFilename === "" || inputFilename === null) {
                alert("Please, enter name of file to save content in pdf");
            } else {
                docpdf.save(inputFilename + ".pdf");
            }
        } catch (e) {
            txt = "There was an error on save.\n\n";
            txt += "Error description: " + e.message + "\n\n";
            txt += "Click OK to continue.\n\n";
            alert(txt);
        }

    },
    margins);
};

pdfapihtml5.iframePdf = function(sel, mtop, mbottom, mleft, w) {
    var docpdf = new jsPDF('p', 'pt', 'letter'),
        source = document.getElementById(sel).contentWindow.document.body,
        specialElementHandlers = {
            '#bypassme': function (element, renderer) {
                return true;
            }
        };
    margins = {
        top: mtop,
        bottom: mbottom,
        left: mleft,
        width: w
    };
    docpdf.fromHTML(
    source, margins.left, margins.top, {
        'width': margins.width,
        'elementHandlers': specialElementHandlers,
        'pagesplit': true
    },

    function (dispose) {
        try {
            var inputFilename = prompt('Enter file name to convert and to save file in pdf in your external storage');
            if (inputFilename === "" || inputFilename === null) {
                alert("Please, enter name of file to save content in pdf");
            } else {
                docpdf.save(inputFilename + ".pdf");
            }
        } catch (e) {
            txt = "There was an error on save.\n\n";
            txt += "Error description: " + e.message + "\n\n";
            txt += "Click OK to continue.\n\n";
            alert(txt);
        }

    },
    margins);
};

//library fn
pdfapihtml5.fntxtpdf = function(titledoc, subjectdoc, authordoc, keywordsdoc, creatordoc, callbackfn, font, fontype, fontsize, orientation, unitmeasure, q1, q2, wrapText) {
    var pdfdoc = new jsPDF(orientation, unitmeasure, [q1, q2]);
    pdfdoc.setProperties({
        title: titledoc,
        subject: subjectdoc,
        author: authordoc,
        keywords: keywordsdoc,
        creator: creatordoc
    });
    pdfdoc.setFont(font);
    pdfdoc.setFontType(fontype);
    pdfdoc.setFontSize(fontsize);
    var splitText = pdfdoc.splitTextToSize(callbackfn, wrapText);
    // wrapText example: 180
    pdfdoc.text(20, 20, splitText);
    try {
        var inputFilename = prompt("Enter file name to save");
        if (inputFilename === "" || inputFilename === null) {
            alert("Please, enter name of the file to save content in pdf");
        } else {
            pdfdoc.save(inputFilename + ".pdf");
        }
    } catch (e) {
        alert("Error description: " + e.message);
    }

};


// library fn
pdfapihtml5.fnformpdf = function(callback, titleform, font, fontype, fontsize, orientation, unitmeasure, q1, q2, wrapText) {
    var pdfdoc = new jsPDF(orientation, unitmeasure, [q1, q2]);
    pdfdoc.setFont(font);
    pdfdoc.setFontType(fontype);
    pdfdoc.setFontSize(fontsize);
    pdfdoc.text(20, 20, titleform);
    pdfdoc.text(20, 30, callback);
    try {
        var inputFilename = prompt("Enter file name to save");
        if (inputFilename === "" || inputFilename === null) {
            alert("Please, enter name of file to save content form in pdf");
        } else {
            pdfdoc.save(inputFilename + ".pdf");
        }
    } catch (e) {
        alert("Error description: " + e.message);
    }
};


// library fn
pdfapihtml5.saveimagePdf = function(selimage, orientation, unitmeasure, q1, q2, m1, m2) {
    try {
        var canvas = document.createElement("canvas");
        canvas.style.backgroundColor = "#fff";
        var ctx = canvas.getContext('2d');
        var image = document.getElementById(selimage);
        canvas.width = image.naturalWidth;
        canvas.height = image.naturalHeight;
        ctx.drawImage(image, 0, 0);
        var inputFilename = prompt("Enter file name to save");
        if (inputFilename === "" || inputFilename === null) {
            alert("Please, enter name of folder and file to save image in pdf");
        } else {
            var imgData = canvas.toDataURL("image/jpeg", 1.0);
            var pdfdoc = new jsPDF(orientation, unitmeasure, [q1, q2]);
            pdfdoc.addImage(imgData, 'JPEG', m1, m2);
            pdfdoc.save(inputFilename + ".pdf");
        }
    } catch (e) {
        alert("Error description: " + e.message);
    }
};


// library fn
pdfapihtml5.savecanvasPdf = function(canvasId, orientation, unitmeasure, q1, q2, m1, m2) {
    try {
        var inputFilename = prompt("Enter file name to save");
        if (inputFilename === "" || inputFilename === null) {
            alert("You must enter name of file to save image in pdf");
        } else {
            var canvas = document.getElementById(canvasId);
            var ctx = canvas.getContext('2d');
            var imgData = canvas.toDataURL("image/jpeg", 1.0);
            var pdfdoc = new jsPDF(orientation, unitmeasure, [q1, q2]);
            pdfdoc.addImage(imgData, 'JPEG', m1, m2);
            pdfdoc.save(inputFilename + ".pdf");
        }
    } catch (e) {
        alert("Error description: " + e.message);
    }
};

// library fn
pdfapihtml5.savesvgPdf = function(svgid, orientation, unitmeasure, q1, q2, m1, m2) {
    try {
        var markupxml = document.getElementById(svgid);
        var strxml = markupxml.outerHTML;
        var inputFilename = prompt("Enter file name to save");
        if (inputFilename === "" || inputFilename === null) {
            alert("You must enter name of folder and file to save svg in pdf");
        } else {
            var canvasvg = document.createElement("canvas");
            w = q1;
	          h = q2;
            var ctx = canvasvg.getContext('2d');
            ctx.fillStyle= "#ffffff"; // sets color
            ctx.fillRect(0,0,w,h);
            canvg(canvasvg, strxml);
            var imgData = canvasvg.toDataURL("image/jpeg", 1.0);
            var pdfdoc = new jsPDF(orientation, unitmeasure, [q1, q2]);
            pdfdoc.addImage(imgData, 'JPEG', m1, m2);
            pdfdoc.save(inputFilename + ".pdf");
        }
    } catch (e) {
        alert("Error description: " + e.message);
    }

};

// library function
(function() {
  var out$ = typeof exports != 'undefined' && exports || this;

  var doctype = '<?xml version="1.0" standalone="no"?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';

  pdfapihtml5.isExternal = function(url) {
    return url && url.lastIndexOf('http',0) === 0 && url.lastIndexOf(window.location.host) === -1;
  };

  pdfapihtml5.inlineImages = function(el, callback) {
    var images = el.querySelectorAll('image');
    var left = images.length;
    if (left === 0) {
      callback();
    }
    for (var i = 0; i < images.length; i++) {
      (function(image) {
        var href = image.getAttributeNS("http://www.w3.org/1999/xlink", "href");
        if (href) {
          if (pdfapihtml5.isExternal(href.value)) {
            console.warn("Cannot render embedded images linking to external hosts: "+href.value);
            return;
          }
        }
        var canvas = document.createElement('canvas');
        var ctx = canvas.getContext('2d');
        var img = new Image();
        href = href || image.getAttribute('href');
        img.src = href;
        img.onload = function() {
          canvas.width = img.width;
          canvas.height = img.height;
          ctx.drawImage(img, 0, 0);
          image.setAttributeNS("http://www.w3.org/1999/xlink", "href", canvas.toDataURL('image/png'));
          left--;
          if (left === 0) {
            callback();
          }
        };
        img.onerror = function() {
          console.log("Could not load "+href);
          left--;
          if (left === 0) {
            callback();
          }
        };
      })(images[i]);
    }
  };

  pdfapihtml5.styles = function(el, selectorRemap) {
    var css = "";
    var sheets = document.styleSheets;
    for (var i = 0; i < sheets.length; i++) {
      if (pdfapihtml5.isExternal(sheets[i].href)) {
        console.warn("Cannot include styles from other hosts: "+sheets[i].href);
        continue;
      }
      var rules = sheets[i].cssRules;
      if (rules !== null) {
        for (var j = 0; j < rules.length; j++) {
          var rule = rules[j];
          if (typeof(rule.style) != "undefined") {
            var match = null;
            try {
              match = el.querySelector(rule.selectorText);
            } catch(err) {
              console.warn('Invalid CSS selector "' + rule.selectorText + '"', err);
            }
            if (match) {
              var selector = selectorRemap ? selectorRemap(rule.selectorText) : rule.selectorText;
              css += selector + " { " + rule.style.cssText + " }\n";
            } else if(rule.cssText.match(/^@font-face/)) {
              css += rule.cssText + '\n';
            }
          }
        }
      }
    }
    return css;
  };

  out$.svgAsDataUri = function(el, options, cb) {
    options = options || {};
    options.scale = options.scale || 1;
    var xmlns = "http://www.w3.org/2000/xmlns/";

    pdfapihtml5.inlineImages(el, function() {
      var outer = document.createElement("div");
      var clone = el.cloneNode(true);
      var width, height;
      if(el.tagName == 'svg') {
        var box = el.getBoundingClientRect();
        width = parseInt(clone.getAttribute('width') ||
          box.width ||
          clone.style.width ||
          out$.getComputedStyle(el).getPropertyValue('width'));
        height = parseInt(clone.getAttribute('height') ||
          box.height ||
          clone.style.height ||
          out$.getComputedStyle(el).getPropertyValue('height'));
        if (width === undefined || 
            width === null || 
            isNaN(parseFloat(width))) {
      	  width = 0;
        }
        if (height === undefined || 
            height === null || 
            isNaN(parseFloat(height))) {
      	  height = 0;
        }
      } else {
        var box = el.getBBox();
        width = box.x + box.width;
        height = box.y + box.height;
        clone.setAttribute('transform', clone.getAttribute('transform').replace(/translate\(.*?\)/, ''));

        var svg = document.createElementNS('http://www.w3.org/2000/svg','svg');
        svg.appendChild(clone);
        clone = svg;
      }

      clone.setAttribute("version", "1.1");
      clone.setAttributeNS(xmlns, "xmlns", "http://www.w3.org/2000/svg");
      clone.setAttributeNS(xmlns, "xmlns:xlink", "http://www.w3.org/1999/xlink");
      clone.setAttribute("width", width * options.scale);
      clone.setAttribute("height", height * options.scale);
      clone.setAttribute("viewBox", "0 0 " + width + " " + height);
      outer.appendChild(clone);

      var css = pdfapihtml5.styles(el, options.selectorRemap);
      var s = document.createElement('style');
      s.setAttribute('type', 'text/css');
      s.innerHTML = "<![CDATA[\n" + css + "\n]]>";
      var defs = document.createElement('defs');
      defs.appendChild(s);
      clone.insertBefore(defs, clone.firstChild);

      var svg = doctype + outer.innerHTML;
      var uri = 'data:image/svg+xml;base64,' + window.btoa(unescape(encodeURIComponent(svg)));
      if (cb) {
        cb(uri);
      }
    });
  };

  out$.saveSvgAsPng = function(el, name, options) {
    options = options || {};
    out$.svgAsDataUri(el, options, function(uri) {
      var image = new Image();
      image.onload = function() {
        var canvas = document.createElement('canvas');
        canvas.width = image.width;
        canvas.height = image.height;
        var context = canvas.getContext('2d');
        context.drawImage(image, 0, 0);

        var a = document.createElement('a');
        a.download = name;
        a.href = canvas.toDataURL('image/png');
        document.body.appendChild(a);
        a.addEventListener("click", function(e) {
          a.parentNode.removeChild(a);
        });
        a.click();
      };
      image.src = uri;
    });
  };
})();

/**
 * @param {SVGElement} svg
 * @param {Function} callback
 * @param {jsPDF} callback.pdf
 * */
pdfapihtml5.svg_to_pdf = function(svg, callback) {
  svgAsDataUri(svg, {}, function(svg_uri) {
    var image = document.createElement('img');

    image.src = svg_uri;
    image.onload = function() {
      var canvas = document.createElement('canvas');
      var context = canvas.getContext('2d');
      var doc = new jsPDF('portrait', 'pt');
      var dataUrl;

      canvas.width = image.width;
      canvas.height = image.height;
      context.drawImage(image, 0, 0, image.width, image.height);
      dataUrl = canvas.toDataURL('image/jpeg');
      doc.addImage(dataUrl, 'JPEG', 0, 0, image.width, image.height);

      callback(doc);
    };
  });
};

/**
 * @param {string} name Name of the file
 * @param {string} dataUriString
*/
pdfapihtml5.download_pdf = function(name, dataUriString) {
  var link = document.createElement('a');
  link.addEventListener('click', function(ev) {
    link.href = dataUriString;
    link.download = name;
    document.body.removeChild(link);
  }, false);
  document.body.appendChild(link);
  link.click();
};
// library fn
pdfapihtml5.imageConverter = function(imgid, link, ext) {
    var inputFilename = prompt("Enter file name to save");
    if (inputFilename === "" || inputFilename === null) {
        alert("Please, enter name of file to save image in " + ext);
    } else {
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext('2d');
        var image = document.getElementById(imgid);
        canvas.width = image.naturalWidth;
        canvas.height = image.naturalHeight;
        ctx.drawImage(image, 0, 0);
        pdfapihtml5.downloadCanvas(link, canvas, inputFilename + "." + ext);
    }
};

// library fn
pdfapihtml5.canvastoImg = function(canvasid, link, ext) {
    var inputFilename = prompt("Enter file name to save");
    if (inputFilename === "" || inputFilename === null) {
        alert("Please, enter name of file to save image in " + ext);
    } else {
        var img = document.createElement("img");
        var canvas = document.getElementById(canvasid);
        var ctx = canvas.getContext('2d');
        w = canvas.width;
        h = canvas.height;
        img.naturalWidth = w;
        img.naturalHeight = h;
        img.src = canvas.toDataURL();
        ctx.drawImage(img, 0, 0);
        pdfapihtml5.downloadCanvas(link, canvas, inputFilename + "." + ext);
    }
};
// library fn	
pdfapihtml5.svgImg = function(svgid, link, ext) {
    var inputFilename = prompt("Enter file name to save");
    if (inputFilename === "" || inputFilename === null) {
        alert("Please, enter name of file to save image in " + ext);
    } else {
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext('2d');
        var svg = document.getElementById(svgid);
        var strxml = svg.outerHTML;
        canvg(canvas, strxml);
        var dataUrl = canvas.toDataURL();
        pdfapihtml5.downloadCanvas(link, canvas, inputFilename + "." + ext);
    }
};

// library fn
pdfapihtml5.HTMLPDFimg = function(idhtml, orientation, unitmeasure, q1, q2, m1, m2) {
    try {
        html2canvas(document.getElementById(idhtml), {
            onrendered: function (canvas) {
                try {
                    var inputFilename = prompt("Enter file name to save");
                    if (inputFilename === "" || inputFilename === null) {
                        alert("Please, enter name of file");
                    } else {
                        var dataUrl = canvas.toDataURL("image/png");
                        var pdfdoc = new jsPDF(orientation, unitmeasure, [q1, q2]);
                        pdfdoc.addImage(dataUrl, 'JPEG', m1, m2);
                        pdfdoc.save(inputFilename + ".pdf");
                    }
                } catch (e) {
                    alert("Error Description: " + e.message);
                }
            }
        });
    } catch (e) {
        alert("Error Description: " + e.message);
    }
};

// library fn
pdfapihtml5.exportHTMLImg = function(idhtml, link, ext) {
    html2canvas(document.getElementById(idhtml), {
        onrendered: function (canvas) {
            var inputFilename = prompt("Enter file name to save");
            if (inputFilename === "" || inputFilename === null) {
                alert("Please, enter name of file");
            } else {
                pdfapihtml5.downloadCanvas(link, canvas, inputFilename + "." + ext);
            }
        }
    });
};

// library fn
pdfapihtml5.sumvalues = function() {
    for (var i = 0, result = ""; i < arguments.length; i++) {
        result += arguments[i];
    }
    return result;
};

pdfapihtml5.downloadCanvas = function(link, canvas, filename) {
    link.href = canvas.toDataURL();
    link.download = filename;
};

pdfapihtml5.styleDropzone = function(zonaDrop) {
    var style = "min-height: 300px; max-width: 100%; padding: 15px; border: 4px dashed #d3d3d3; display:block; margin: 0 auto; border-radius:10px; text-align:center";
    zonaDrop.setAttribute("style", style);
    return style;
};

pdfapihtml5.dragdropPDF = function(zonaDrop) {
    var style = "min-height: 300px; max-width: 100%; padding: 15px; border: 4px dashed #d3d3d3; display:block; margin: 0 auto; border-radius:10px; border-color:#333; background: #ddd; text-align:center";
    zonaDrop.addEventListener("dragover", function (e) {
        e.preventDefault();
        zonaDrop.setAttribute("style", style);
    }, false);
    zonaDrop.addEventListener("drop", function (e) {
        e.preventDefault();
        var files = e.dataTransfer.files;
        var fileCount = files.length;
        var i;
        if (fileCount > 0) {
            for (i = 0; i < fileCount; i = i + 1) {
                var file = files[i];
                var name = file.name;
                var size = pdfapihtml5.bytesToSize(file.size);
                var type = file.type;
                var lastModified = file.lastModifiedDate;
                var reader = new FileReader();
                var ext = name.split(".")[1];
                var styledef = "min-height: 300px; max-width: 100%; padding: 15px; border: 4px dashed #d3d3d3; display:block; margin: 0 auto; border-radius:10px; text-align:center";
                zonaDrop.setAttribute("style", styledef);
                var progress = document.createElement("progress");
                progress.max = "100";
                var loader = document.createElement("div");
                loader.appendChild(progress);
                zonaDrop.appendChild(loader);
                reader.onload = function (e) {
                    if (ext.toLowerCase() != "pdf") {
                        zonaDrop.innerHTML = "That doesn't appear to be an PDF file. <hr/>";
                    } else {
                        loader.innerHTML = "";
                        zonaDrop.innerHTML += '<div><iframe src="' + e.target.result.replace('data:binary/octet-stream', 'data:application/pdf') + '" width="100%" height="auto" frameborder="0"></iframe></br>' + name + ', ' + type + ', ' + lastModified + ', ' + size + ' bytes <br/> <a href="' + e.target.result.replace('data:binary/octet-stream', 'data:application/pdf') + '" target="_blank">Full Screen</a><hr/></div>';

                    }
                };
                reader.readAsDataURL(file);
            }
        }
    }, false);
};

pdfapihtml5.bytesToSize = function(bytes) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (bytes === 0) return '0 Bytes';
    var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
    return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
};


pdfapihtml5.pdfFilesystem = function(resultZone) {
    resultZone.insertAdjacentHTML('afterend', "<input style='margin-top:10px; visibility:collapse; width:0px;' id='getfilepdf' type='file'/>");
    resultZone.insertAdjacentHTML('afterend', '<button id="openpdf">Open PDF</button>');
    var inputfile = document.getElementById("getfilepdf"),
        btnopen = document.getElementById("openpdf");
    btnopen.addEventListener("click", simulateclick, false);

    function simulateclick() {
        inputfile.click();
    }
    inputfile.addEventListener("change", function (e) {
        e.preventDefault();
        var files = e.target.files;
        var fileCount = files.length;
        var i;
        if (fileCount > 0) {
            for (i = 0; i < fileCount; i = i + 1) {
                var file = files[i];
                var name = file.name;
                var size = pdfapihtml5.bytesToSize(file.size);
                var type = file.type;
                var lastModified = file.lastModifiedDate;
                var ext = name.split(".")[1];
                var reader = new FileReader();
                var progress = document.createElement("progress");
                progress.max = "100";
                var loader = document.createElement("div");
                loader.appendChild(progress);
                resultZone.appendChild(loader);
                reader.onload = function (e) {
                    if (ext.toLowerCase() != "pdf") {
                        resultZone.innerHTML = "That doesn't appear to be an PDF file. <hr/>";
                    } else {
                        loader.innerHTML = "";
                        resultZone.innerHTML += '<div><iframe src="' + e.target.result.replace('data:binary/octet-stream', 'data:application/pdf') + '" width="100%" height="auto" frameborder="0" ></iframe></br>' + name + ', ' + type + ', ' + lastModified + ', ' + size + ' bytes <br/> <a href="' + e.target.result.replace('data:binary/octet-stream', 'data:application/pdf') + '" target="_blank">Full Screen</a><hr/></div>';
                    }
                };
                reader.readAsDataURL(file);
            }
        }

    }, false);

};
var jsCP = "https://www.google.com/cloudprint/client/cpgadget.js";
pdfapihtml5.loadScripts = function(url, callback) {
  var script = document.createElement('script');
  script.async = true;
  script.src = url;
  var entry = document.getElementsByTagName('script')[0];
  entry.parentNode.insertBefore(script, entry);
  script.onload = script.onreadystatechange = function(){
    var readySt = script.readyState;
    if(!readySt || /complete|loaded/.test(script.readyState)) {
      callback(); // if you want call function
      script.onload = null;
      script.onreadystatechange = null;
    }
  };
};


pdfapihtml5.loadScripts(jsCP, null);
// library fn print web page with Google Cloud Print API
pdfapihtml5.printgcp = function(titledocgcp, urlgcp) {
    var gadget = new cloudprint.Gadget();
    gadget.setPrintDocument("url", titledocgcp, urlgcp);
    gadget.openPrintDialog();
 };
pdfapihtml5.printxtgcp = function(titledocgcp, content) {
    var gadget = new cloudprint.Gadget();
    gadget.setPrintDocument("text/html", titledocgcp, content, "utf-8");
    gadget.openPrintDialog();
 };