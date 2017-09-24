#!/bin/bash

baiduyun()
{
    from="$1"
    to="$2"

    [ -d "${from}" ]&& {
        tar -cvzf ${from}.tar.gz "${from}"
        from="${from}.tar.gz"
    }

    [ "${to}" == "" ] && to="/upload/`date +%F`"
    echo "upload ${from} to baiduyun : ${to}"
    fileName=${from##*/}
    encodeFile=$(python -c "import urllib; print urllib.quote('''$fileName''')")
    dir=$(python -c "import urllib; print urllib.quote('''${to}''')")

   httpcode=$(curl --connect-timeout 15 -m 3600 -k -o /dev/null -s -w %{http_code} \
    -X POST \
    -F file="@${from}" \
    -F filename="${fileName}" \
    -H 'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' \
    -H 'Accept-Language: zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3' \
    -H 'Cache-Control: no-cache' \
    -H 'Connection: keep-alive' \
    -H 'DNT: 1' \
    -H 'Host: c.pcs.baidu.com' \
    -H 'Origin: http://pan.baidu.com' \
    -H 'Pragma: no-cache' \
    -H 'Referer: http://pan.baidu.com/disk/home' \
    -H 'Accept-Encoding: identity' \
    -H 'User-Agent: Mozilla/5.0 (X11; Linux; rv:5.0) Gecko/5.0 Firefox/5.0' \
    -H 'Cookie: BDUSS='${MMMBDUSS} \
    "https://c.pcs.baidu.com/rest/2.0/pcs/file?method=upload&ondup=overwrite&app_id=250528&dir=${dir}&filename=${encodeFile}")

    echo ${httpcode}
}

baiduyun "$@"
