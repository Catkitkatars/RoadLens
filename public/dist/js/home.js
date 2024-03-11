import{L as l}from"./index.js";function v(e){return`
    <div class="side_camera_block">
        <span class="icon-closed material-symbols-outlined">
        close
        </span>
        <div class="info-box">
            <h3 class="name-block_h3">Инфо</h3>
            <div class="info-box_specification">
                <p>UUID:</p>
                <div class="line-style"></div>
                <h5>${e.properties.id}</h5>
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
                <p>Направление:</p>
                <div class="line-style"></div>
                <h5>${e.properties.direction}</h5>
            </div>
            <div class="info-box_specification">
                <p>Скорость:</p>
                <div class="line-style"></div>
                <h5>${e.properties.speed}</h5>
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
    </div>`}function p(e){let t=e.getCenter(),s=e.getZoom();return`${t.lat.toFixed(6)}/${t.lng.toFixed(6)}/${s}`}let i={point1:{id:1,type:"Маломощный",model:"Автоураган",direction:"В спину",speed:60,dateCreate:"18.02.2024",lastUpdate:"20.02.2024",camera:[6.82775,52.43377],target:[6.83085,52.43385]},point2:{id:2,type:"Стационарный",model:"Кордон",direction:"В лоб",speed:80,dateCreate:"16.02.2024",lastUpdate:"22.02.2024",camera:[6.83003,52.43382],target:[6.82691,52.43369]},point3:{id:3,type:"Контроль светофора",model:"Кордон",direction:"В лоб",speed:40,dateCreate:"10.02.2024",lastUpdate:"10.02.2024",camera:[6.83146,52.43525],target:[6.83241,52.43388]},point4:{id:4,type:"Видеоблок",model:"Стрелка",direction:"В спину",speed:0,dateCreate:"14.02.2024",lastUpdate:"14.02.2024",camera:[6.83489,52.43356],target:[6.83276,52.43377]},point5:{id:5,type:"Тренога",model:"Скат",direction:"В спину",speed:90,dateCreate:"01.02.2024",lastUpdate:"13.02.2024",camera:[6.83337,52.43309],target:[6.83428,52.43131]}};const y={draggable:!1,control:!1,cameraIcon:L.icon({iconUrl:"/dist/images/main-pin.png",iconSize:[38,38],iconAnchor:[19,35]}),targetIcon:L.icon({iconUrl:"/dist/images/marker.svg",iconSize:[0,0],iconAnchor:[16,16]}),angleIcon:L.icon({iconUrl:"/dist/images/marker.svg",iconSize:[0,0],iconAnchor:[16,16]}),outlineStyle:{color:"#03e9f4",opacity:0,weight:2,dashArray:"1, 1",lineCap:"round",lineJoin:"round"},fillStyle:{weight:0,fillOpacity:.3,fillColor:"#032b2d"}};var n=l.map("map",{center:[52.43369,6.83442],zoom:17});l.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png",{attribution:'&copy; <a href="#">RoadLens</a>'}).addTo(n);let h=`http://localhost:8080/map/${latitude.toFixed(6)}/${longitude.toFixed(6)}/${zoom}`;window.history.replaceState({},"",h);n.on("moveend",function(e){let t="http://localhost:8080/map/"+p(n);window.history.replaceState({},"",t)});let u=l.Control.extend({options:{position:"bottomright"},onAdd:function(e){let t=l.DomUtil.create("div","addButton"),s=l.DomUtil.create("a","button-add",t);s.innerHTML="Добавить камеру",e.on("move",function(){r(e)});function r(c){let f="http://localhost:8080/edit/"+p(c);s.setAttribute("href",f)}return r(e),t}});n.addControl(new u);let d=l.layerGroup(),m=l.layerGroup(),a=document.querySelector(".section_camera_info"),o=null;for(let e in i){let t={type:"Feature",properties:{angle:20,id:i[e].id,type:i[e].type,model:i[e].model,direction:i[e].direction,speed:i[e].speed,dateCreate:i[e].dateCreate,lastUpdate:i[e].lastUpdate},geometry:{type:"GeometryCollection",geometries:[{type:"Point",coordinates:i[e].camera},{type:"Point",coordinates:i[e].target}]}},s=l.geotagPhoto.camera(t,y).on("click",function(r){o===this?(this.setStyle({fillColor:"#032b2d",fillOpacity:.3}),o=null,a.classList.remove("section_camera_info_move"),a.innerHTML=""):(o&&(o.setStyle({fillColor:"#032b2d",fillOpacity:.3}),a.classList.remove("section_camera_info_move"),a.innerHTML=""),this.setStyle({fillColor:"#056c71",fillOpacity:.7}),o=this,a.classList.add("section_camera_info_move"),a.innerHTML=v(t),document.querySelector(".icon-closed").addEventListener("click",()=>{a.classList.remove("section_camera_info_move"),a.innerHTML="",o.setStyle({fillColor:"#032b2d",fillOpacity:.3}),o=null}))}).on("mouseover",function(r){o!=this&&this.setStyle({fillOpacity:.6})}).on("mouseout",function(r){o!=this&&this.setStyle({fillOpacity:.3})});d.addLayer(s)}d.addTo(n);m.addTo(n);let g={гибдд:d,видео:m};l.control.layers(null,g).addTo(n);
