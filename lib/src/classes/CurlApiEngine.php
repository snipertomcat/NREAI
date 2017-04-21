<?php
/**
 * Created by: Jesse Griffin
 * Date: 4/2/2017
 */

class CurlApiEngine
{

    /**
     * Makes a curl call to the St Louis Fed's site, obtains current daily rate for ticker "DGS10", saves to an
     * output file, and returns true
     *
     * @return bool $success
     *
     */
    public static function pullRatesCsv()
    {

        $curl = curl_init();
        $fp = fopen(self::getOutputFilename(), 'w+');

        //$startDate and $endDate must be in 'Y-m-d' format
        $today = new \DateTime('now');
        $startDate = $today->diff(new \DateTime('yesterday'))->format('Y-m-d');
        $endDate = $today->format('YYYY-mm-dd');

        $curlString = 'https://fred.stlouisfed.org/graph/fredgraph.csv?chart_type=line&recession_bars=on&log_scales=&bgcolor="%"23e1e9f0&graph_bgcolor="%"23ffffff&fo=Open+Sans&ts=12&tts=12&txtcolor="%"23444444&show_legend=yes&show_axis_titles=yes&drp=0&cosd='.$startDate.'&coed='.$endDate.'&height=450&stacking=&range=Custom&mode=fred&id=DGS10&transformation=lin&nd='.$endDate.'&ost=-99999&oet=99999&lsv=&lev=&mma=0&fml=a&fgst=lin&fgsnd=2009-06-01&fq=Daily&fam=avg&vintage_date=&revision_date=&line_color="%"234572a7&line_style=solid&lw=2&scale=left&mark_type=none&mw=2&width=1168" -H "Host: fred.stlouisfed.org" -H "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64; rv:52.0) Gecko/20100101 Firefox/52.0" -H "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8" -H "Accept-Language: en-US,en;q=0.5" --compressed -H "Referer: https://fred.stlouisfed.org/series/DGS10" -H "Cookie: _ga=GA1.2.325127405.1491144532; _ga=GA1.3.325127405.1491144532; research-site=5ikqc85np3ac8tfm9iq16m3uj6; research-lirua=1; research-liruid=fdb93585e505d74705e7a74e33ffef57; _gat_UA-9926151-1=1; _gali=download-data-csv; _gat=1" -H "DNT: 1" -H "Connection: keep-alive" -H "Upgrade-Insecure-Requests: 1';
        curl_setopt($curl, CURLOPT_URL, $curlString);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_VERBOSE, 1);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_WRITEFUNCTION, function ($cp, $data) use ($fp) { return fwrite($fp, $data); });
        curl_exec($curl);

        curl_close($curl);
        fclose($fp);

        return true;
        /*
        $explode = explode("\r\n", $output);
        array_pop($explode);
        */
    }

    public static function getOutputFilename()
    {
        return 'curl_output.txt';
    }

}
