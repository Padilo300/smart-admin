<?php

namespace App\Http\Controllers\google;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class reviewBusiness extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /*
       💬 Get Google-Reviews with PHP cURL & without API Key
       =====================================================
       **This is a dirty but usefull way to grab the first 8 most relevant reviews from Google with cURL and without the use of an API Key**
       How to find the needed CID No:
         - use: [http://ryanbradley.com/tools/google-cid-finder]
         - and do a search for your business name
       Parameter
       ---------
       ```PHP
       $options = array(
         'google_maps_review_cid' => '17311646584374698221', // Customer Identification (CID)
         'show_only_if_with_text' => false, // true = show only reviews that have text
         'show_only_if_greater_x' => 0,     // (0-4) only show reviews with more than x stars
         'show_rule_after_review' => true,  // false = don't show <hr> Tag after each review
         'show_blank_star_till_5' => true,  // false = don't show always 5 stars e.g. ⭐⭐⭐☆☆
       );
       echo getReviews($options);
       ```
       > HINT: Use .quote in you CSS to style the output
       ###### Copyright 2019 Igor Gaffling
       */
    public function get(){



        $option = array(
            'google_maps_review_cid' => '17311646584374698221', // Customer Identification (CID)
            'show_only_if_with_text' => false, // true = show only reviews that have text
            'show_only_if_greater_x' => 0,     // (0-4) only show reviews with more than x stars
            'show_rule_after_review' => true,  // false = don't show <hr> Tag after each review
            'show_blank_star_till_5' => true,  // false = don't show always 5 stars e.g. ⭐⭐⭐☆☆
        );

            $ch = curl_init('https://www.google.com/maps?cid='.$option['google_maps_review_cid']);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla / 5.0 (Windows; U; Windows NT 5.1; en - US; rv:1.8.1.6) Gecko / 20070725 Firefox / 2.0.0.6");
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
            $result = curl_exec($ch);
            curl_close($ch);
            $pattern = '/window\.APP_INITIALIZATION_STATE(.*);window\.APP_FLAGS=/ms';
            if ( preg_match($pattern, $result, $match) ) {
                $match[1] = trim($match[1], ' =;'); /* fix json */
                $reviews  = json_decode($match[1]);
                $reviews  = ltrim($reviews[3][6], ")]}'"); /* fix json */
                $reviews  = json_decode($reviews);
                $customer = $reviews[0][1][0][14][18];
                $reviews  = $reviews[0][1][0][14][52][0];
            }
            $return = '';
            if (isset($reviews)) {
                $return .= '<div class="quote"><strong>'.$customer.'</strong><br>';
                if ($option['show_rule_after_review'] == true) $return .= '<hr size="1">';
                foreach ($reviews as $review) {
                    if ($option['show_only_if_with_text'] == true and empty($review[3])) continue;
                    if ($review[4] <= $option['show_only_if_greater_x']) continue;
                    for ($i=1; $i <= $review[4]; ++$i) $return .= '⭐'; /* RATING */
                    if ($option['show_blank_star_till_5'] == true)
                        for ($i=1; $i <= 5-$review[4]; ++$i) $return .= '☆'; /* RATING */
                    $return .= '<p>'.$review[3].'<br>'; /* TEXT */
                    $return .= '<small>'.$review[0][1].'</small></p>'; /* AUTHOR */
                    if ($option['show_rule_after_review'] == true) $return .= '<hr size="1">';
                }
                $return .= '</div>';
            }
            return $return;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
