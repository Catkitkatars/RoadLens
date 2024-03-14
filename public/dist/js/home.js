import{L as s}from"./index.js";function h(e){return`
    <div class="side_camera_block">
        <span class="icon-closed material-symbols-outlined">
        close
        </span>
        <div class="info-box">
            <h3 class="name-block_h3">Инфо</h3>
            <div class="info-box_specification">
                <p>UUID:</p>
                <div class="line-style"></div>
                <h5>${e.properties.uuid}</h5>
            </div>
            <div class="info-box_specification">
                <p>Тип:</p>
                <div class="line-style"></div>
                <h5>${e.properties.type}</h5>
            </div>
            <div class="info-box_specification">
                <p>Модель:</p>
                <div class="line-style"></div>
                <h5>${e.properties.model}</h5>
            </div>
            <div class="info-box_specification">
                <p>Скорость легковые:</p>
                <div class="line-style"></div>
                <h5>${e.properties.car_speed}</h5>
            </div>
            <div class="info-box_specification">
                <p>Скорость грузовые:</p>
                <div class="line-style"></div>
                <h5>${e.properties.truck_speed}</h5>
            </div>
            <div class="info-box_specification">
                <p>Модератор:</p>
                <div class="line-style"></div>
                <h5>${e.properties.user}</h5>
            </div>
            <div class="info-box_specification">
                <p>Дата создания:</p>
                <div class="line-style"></div>
                <h5>${e.properties.dateCreate}</h5>
            </div>
            <div class="info-box_specification">
                <p>Дата последних изменений:</p>
                <div class="line-style"></div>
                <h5>${e.properties.lastUpdate}</h5>
            </div>
            <div class="edit-submit">
                <a href="localhost:8080/edit/${e.properties.id}">
                    Изменить
                </a>
            </div>
        </div>
    </div>`}function m(e){let t=e.getCenter(),n=e.getZoom();return`${t.lat.toFixed(6)}/${t.lng.toFixed(6)}/${n}`}function u(e){return L.icon({iconUrl:`/dist/images/${e}.png`,iconSize:[38,38],iconAnchor:[19,35]})}function v(e,t){return e.properties.type=t[0][parseInt(e.properties.type)-1],e.properties.model=t[1][parseInt(e.properties.model)-1],e.properties.angle=parseInt(e.properties.angle),e.geometry.geometries[0].coordinates=[parseFloat(e.geometry.geometries[0].coordinates[0]),parseFloat(e.geometry.geometries[0].coordinates[1])],e.geometry.geometries[1].coordinates=[parseFloat(e.geometry.geometries[1].coordinates[0]),parseFloat(e.geometry.geometries[1].coordinates[1])],e}let y=L.Control.extend({options:{position:"bottomright"},onAdd:function(e){let t=L.DomUtil.create("div","addButton"),n=L.DomUtil.create("a","button-add",t);n.innerHTML="Добавить камеру",e.on("move",function(){r(e)});function r(c){let l="http://localhost:8080/edit/"+m(c);n.setAttribute("href",l)}return r(e),t}}),p={draggable:!1,control:!1,cameraIcon:L.icon({iconUrl:"/dist/images/main-pin.png",iconSize:[38,38],iconAnchor:[19,35]}),targetIcon:L.icon({iconUrl:"/dist/images/marker.svg",iconSize:[0,0],iconAnchor:[16,16]}),angleIcon:L.icon({iconUrl:"/dist/images/marker.svg",iconSize:[0,0],iconAnchor:[16,16]}),outlineStyle:{color:"#03e9f4",opacity:0,weight:2,dashArray:"1, 1",lineCap:"round",lineJoin:"round"},fillStyle:{weight:0,fillOpacity:.3,fillColor:"#032b2d"}},g=[["Безрадарный(не шумит)","Радарный(шумит)","Видеоблок","Контроль остановки","Муляж","Контроль светофора","Мобильная камера"],["Кордон","Арена","Крис","Скат","Интегра-КДД","Мангуст","Азимут"]];var o=s.map("map",{center:[52.43369,6.83442],zoom:17});s.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png",{attribution:'&copy; <a href="#">RoadLens</a>'}).addTo(o);let _=`http://localhost:8080/map/${latitude.toFixed(6)}/${longitude.toFixed(6)}/${zoom}`;window.history.replaceState({},"",_);o.on("moveend",function(e){let t="http://localhost:8080/map/"+m(o);window.history.replaceState({},"",t)});o.addControl(new y);let d=s.layerGroup(),f=s.layerGroup(),i=document.querySelector(".section_camera_info"),a=o.getBounds(),C={northEastLat:a._northEast.lat,northEastLng:a._northEast.lng,southWestLat:a._southWest.lat,southWestLng:a._southWest.lng};const S=document.querySelector('meta[name="csrf-token"]').getAttribute("content");fetch("/getCameras",{method:"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":S},body:JSON.stringify(C)}).then(e=>{if(!e.ok)throw new Error("Беда");return e.json()}).then(e=>{let t=null;for(let n in e){p.cameraIcon=u(e[n].properties.type);let r=v(e[n],g),c=s.geotagPhoto.camera(r,p).on("click",function(l){t===this?(this.setStyle({fillColor:"#032b2d",fillOpacity:.3}),t=null,i.classList.remove("section_camera_info_move"),i.innerHTML=""):(t&&(t.setStyle({fillColor:"#032b2d",fillOpacity:.3}),i.classList.remove("section_camera_info_move"),i.innerHTML=""),this.setStyle({fillColor:"#056c71",fillOpacity:.7}),t=this,i.classList.add("section_camera_info_move"),i.innerHTML=h(r),document.querySelector(".icon-closed").addEventListener("click",()=>{i.classList.remove("section_camera_info_move"),i.innerHTML="",t.setStyle({fillColor:"#032b2d",fillOpacity:.3}),t=null}))}).on("mouseover",function(l){t!=this&&this.setStyle({fillOpacity:.6})}).on("mouseout",function(l){t!=this&&this.setStyle({fillOpacity:.3})});d.addLayer(c)}}).catch(e=>{console.error("Error:",e)});d.addTo(o);f.addTo(o);let k={гибдд:d,видео:f};s.control.layers(null,k).addTo(o);
