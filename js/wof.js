var YarWof = (function() {
    
    var self;
    
    var pc = pageConfig;
    // scale for every 16px.
    pc.scaleRange = 16;
    // would be used in initLayer.
    pc.layerCount = Math.ceil(pc.userIdList.length / pc.layerLeafCount);
    pc.leafLength = 72;
    
    // defined in php files already.
    //~ pc.layerLeafCount = 10;
    //~ pc.startRadius = 48;
    //~ pc.radiusRange = 64;
    //~ pc.animationDuiton = 10000;
    
    var view = {
        leavesWrap : false,
        startBtn : false,
        leaves : {},
        layers : [],
        layerScale : [],
        layeredElements : []
    };
    
    var buf = {
        // hashed with degree - userId.
        rotateList : [],
        layerRotateDeg : [],
        winnerDegree : false,
        winnerName : "",
        leaveCount : 0,
        winnerInLayer : 0
    }
    
    var util = {
        fibonacci : function(n) {
            //~ return Math.round((Math.pow((1 + Math.sqrt(5))/2, n) - Math.pow((1 - Math.sqrt(5))/2, n)) / Math.sqrt(5));
            return Math.ceil(pc.userIdList.length / pc.layerCount);
        },
        
        /**
         * index from 0.
         */
        getPosition : function(index, total, radius) {
            
            var deg = (index / total);
            return {
                deg : ~~((deg - 0.25) * 360),
                y : ~~(Math.cos(deg * 2 * Math.PI) * radius),
                x : ~~(Math.sin(deg * 2 * Math.PI) * radius)
            }
        }
    }
    
    var controller = {
        initView : function() {
            var _view = view,
                _pc = pc,
                _buf = buf,
                leaf, leafParent, div, outerDiv, scale,
                leafCount = 0;
            _view.startBtn = document.getElementById("YarStart");
            for (var i in pc.userIdList) {
                leaf = document.getElementById("yarWheelName_" + _pc.userIdList[i]);
                leafParent = leaf.parentNode;
                
                // redefine singlee leaf background.
                div = document.createElement("div");
                div.className = "yar-wheel-item";
                div.title = leaf.title;
                
                // min width : 48px;
                
                // No scale used. All members share the same length.
                //~ scale = Math.min(6, (Math.max(3, Math.ceil(leaf.scrollWidth / _pc.scaleRange)))) * _pc.scaleRange / 64;
                scale = _pc.leafScale;
                
                div.style.webkitTransform = "scale(" + scale + ", 1)";
                div.style.mozTransform = "scale(" + scale + ", 1)";
                div.style.msTransform = "scale(" + scale + ", 1)";
                div.style.oTransform = "scale(" + scale + ", 1)";
                div.style.transform = "scale(" + scale + ", 1)";
                div.style.borderRightColor = "rgba(" + (64 + ~~(192 * Math.random())) + ", " + (64 + ~~(192 * Math.random())) + " , " + (64 + ~~(192 * Math.random())) + ", " + (0.3 + 0.6 * Math.random()) + ")";
                
                // redefine outerdiv for leaves
                outerDiv = document.createElement("div");
                outerDiv.className = "yar-leaf-wrap-display";
                outerDiv.id = "YarLeaf_" + pc.userIdList[i];
                outerDiv.appendChild(leaf);
                outerDiv.appendChild(div);
                
                if (!_view.layerScale[scale]) _view.layerScale[scale] = [];
                _view.layerScale[scale].push(outerDiv);
                _view.leaves[pc.userIdList[i]] = outerDiv;
                ++_buf.leaveCount;
            }
            
            // remove original leaves wrap.
            document.getElementById("YarLeaves").parentNode.removeChild(document.getElementById("YarLeaves"));
        },
        
        initLayer : function() {
            var _view = view,
                _pc = pc,
                _buf = buf,
                wheelWrap = _view.startBtn.parentNode,
                scaleList = [],
                currentScaleId = 0,
                //~ fCount = util.fibonacci(_pc.layerCount + 3) - 2;
                layer = [];
            for (var scale in _view.layerScale) {
                scaleList.push(scale);
            }
            scaleList.reverse();
            
            for (var i = 0; i < _pc.layerCount; ++i) {
                // up to down.
                // don't ask me.
                // as god.
                //~ var layerLeafCount = Math.ceil(util.fibonacci(i + 2) / fCount * _buf.leaveCount),
                var layerLeafCount = _pc.layerLeafCount,
                    layerElement = document.createElement("div"),
                    leafElement;
                
                layer[i] = [];
                for (var j = 0; j < layerLeafCount; ++j) {
                    if (!_view.layerScale[scaleList[currentScaleId]].length) ++currentScaleId;
                    if (!scaleList[currentScaleId]) break;
                    
                    leafElement = _view.layerScale[scaleList[currentScaleId]].pop();
                    layer[i].push(leafElement);
                    
                    layerElement.appendChild(leafElement);
                }
                
                layerElement.className = "yar-leaves";
                layerElement.id = "YarLeaves_" + i;
                
                var layerRadius = _pc.leafLength + _pc.startRadius + _pc.radiusRange * (i + 1) + 16;
                layerElement.style.height = layerRadius * 2 + "px";
                layerElement.style.width = layerRadius * 2 + "px";
                layerElement.style.marginLeft = layerRadius * -1 + "px";
                layerElement.style.marginTop = layerRadius * -1 + "px";
                
                // +10 for some buffer.
                layerElement.style.webkitBorderRadius = layerRadius + 24 + "px";
                layerElement.style.mozBorderRadius = layerRadius + 24 + "px";
                layerElement.style.msBorderRadius = layerRadius + 24 + "px";
                layerElement.style.oBorderRadius = layerRadius + 24 + "px";
                layerElement.style.borderRadius = layerRadius + 24 + "px";
                
                layerElement.style.backgroundColor = "rgba(" + (192 + ~~(64 * Math.random())) + ", " + (192 + ~~(64 * Math.random())) + " , " + (192 + ~~(64 * Math.random())) + ", " + (0.1 + 0.2 * Math.random()) + ")";
                layerElement.style.zIndex = _pc.layerCount - i;
                
                wheelWrap.appendChild(layerElement);
                
                _view.layers[i] = layerElement;
                
                layer[i].sort(function(a,b){
                    return 0.5 - Math.random();
                });
            }
            
            // update view cache.
            _view.layeredElements = layer;
            delete _view.layerScale;
        },
        
        // let's go!
        render : function() {
            
            var _view = view,
                _buf = buf,
                _pc = pc,
                wheelWrap = _view.startBtn.parentNode,
                centerX,
                centerY,
                layerCount = _view.layeredElements.length;
            
            for (var i = 0; i < layerCount; ++i) {
                var layerElemList = _view.layeredElements[i],
                    layerElemCount = layerElemList.length,
                    position,
                    leaf,
                    layerRandRotate = ~~(Math.random() * 180),
                    layer = _view.layers[i];
                
                centerX = layer.clientWidth / 2;
                centerY = layer.clientHeight / 2;
                
                var id;
                for (var j = 0; j < layerElemCount; ++j) {
                    
                    // prevent pepeat.
                    //~ position = util.getPosition(j, layerElemCount, pc.startRadius + pc.radiusRange * util.fibonacci(_view.layeredElements.length - i + 1));
                    position = util.getPosition(j, layerElemCount, pc.startRadius + pc.radiusRange * (i + 1));
                    while ((layerRandRotate + position.deg) in _buf.rotateList) {
                        layerRandRotate = ~~(Math.random() * 180);
                    }
                    // set layer rotate.
                    layer.style.webkitTransform = "rotate(" + layerRandRotate + "deg)";
                    layer.style.mozTransform = "rotate(" + layerRandRotate + "deg)";
                    layer.style.msTransform = "rotate(" + layerRandRotate + "deg)";
                    layer.style.oTransform = "rotate(" + layerRandRotate + "deg)";
                    layer.style.transform = "rotate(" + layerRandRotate + "deg)";
                    
                    leaf = layerElemList[j];
                    
                    leaf.style.webkitTransform = "rotate(" + position.deg + "deg)";
                    leaf.style.mozTransform = "rotate(" + position.deg + "deg)";
                    leaf.style.msTransform = "rotate(" + position.deg + "deg)";
                    leaf.style.oTransform = "rotate(" + position.deg + "deg)";
                    leaf.style.transform = "rotate(" + position.deg + "deg)";
                    
                    leaf.style.left = centerX + position.x - leaf.clientWidth / 2 + "px";
                    leaf.style.top = centerY - position.y - leaf.clientHeight / 2 + "px";
                    
                    // setBuffer.
                    id = leaf.id.match(/_(\d+)/)[1];
                    _buf.rotateList[layerRandRotate + position.deg] = id;
                    if (+id == +_pc.winner) {
                        _buf.winnerDegree = ~~((1 - j / layerElemCount) * 360);
                        _buf.winnerName = document.getElementById("yarWheelName_" + id).innerHTML;
                        _buf.winnerInLayer = i;
                    }
                }
                
                // animation trigger.
                layer.style.opacity = "1";
                
                // update buffer for reposition.
                _buf.layerRotateDeg[i] = layerRandRotate;
            }
        },
        
        initEvent : function() {
            var _view = view;
            _view.startBtn.onclick = function(e) {
                controller.start();
            }
        },
        
        start : function() {
            var _view = view,
                _buf = buf,
                _pc = pc,
                degree,
                layer,
                leafCount;
            for (var i = 0, len = _view.layers.length; i < len; ++i) {
                layer = _view.layers[i];
                layer.className = "yar-leaves yar-leaves-rotate";
                
                if (_buf.winnerInLayer == i) {
                    _buf.layerRotateDeg[i] = degree = ~~(_buf.layerRotateDeg[i] / 360 + 2 + 6 * Math.random()) * 360 + _buf.winnerDegree;
                } else {
                    // no member should be pointed, except for the winner in the winner's layer.
                    leafCount = _view.layeredElements[i].length;
                    
                    // add some rand offset
                    _buf.layerRotateDeg[i] = degree = ~~((~~((_buf.layerRotateDeg[i] * leafCount / 180 + 4 * leafCount + 12 * leafCount * Math.random())/2)*2 + 1) * 180 / leafCount + (180 / leafCount) * (0.5 - Math.random()));
                }
                
                layer.style.webkitTransform = "rotate(" + degree + "deg)";
                layer.style.mozTransform = "rotate(" + degree + "deg)";
                layer.style.msTransform = "rotate(" + degree + "deg)";
                layer.style.oTransform = "rotate(" + degree + "deg)";
                layer.style.transform = "rotate(" + degree + "deg)";
                
                layer.style.webkitTransition = "-webkit-transform " + (pc.animationDuiton / 1000) + "s cubic-bezier(0.4, 0, 0, 1)";
                layer.style.mozTransition = "-moz-transform " + (pc.animationDuiton / 1000) + "s cubic-bezier(0.4, 0, 0, 1)";
                layer.style.msTransition = "-ms-transform " + (pc.animationDuiton / 1000) + "s cubic-bezier(0.4, 0, 0, 1)";
                layer.style.oTransition = "-o-transform " + (pc.animationDuiton / 1000) + "s cubic-bezier(0.4, 0, 0, 1)";
                layer.style.transition = "transform " + (pc.animationDuiton / 1000) + "s cubic-bezier(0.4, 0, 0, 1)";
            }
            setTimeout(function() {
                (_buf.onWinner) && (_buf.onWinner instanceof Function) && _buf.onWinner(_buf.winnerName);
            }, pc.animationDuiton);
        }
    };
    
    return self = {
        init : function() {
            controller.initView();
            // layer ready in view.
            controller.initLayer();
            
            controller.render();
            
            controller.initEvent();
        },
        onWinner : function(callback) {
            buf.onWinner = callback;
        }
    }
})();

YarWof.init();