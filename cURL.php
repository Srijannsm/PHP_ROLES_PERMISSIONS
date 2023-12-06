<!DOCTYPE html>
<html>

<head>
    <title>News Cards</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .card {
            margin-bottom: 20px;
        }

        .card-title {
            font-weight: bold;
        }

        .card-text {
            margin-top: 10px;
        }

        .card-footer {
            font-size: 14px;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <?php
            $api_news = '{
                "status":"success",
                "totalResults":7367,
                "results":[{"title":"STATSCORE Expands Support for Cricket with New Widget","link":"https://www.gamblingnews.com/news/statscore-expands-support-for-cricket-with-new-widget/","keywords":["Sports","global","sports","statscore"],"creator":["Fiona Simmons"],"video_url":null,"description":"The sports tech and data firm develops the new widget to help strengthen its presence in the particular sport and offer partner operators the opportunity to let fans enjoy their favorite game in an intuitive and value-added way. The new cricket widget by STATSCORE comes with real-time updates, visualizations, updates, and simple integration to make […]","content":"The sports tech and data firm develops the new widget to help strengthen its presence in the particular sport and offer partner operators the opportunity to let fans enjoy their favorite game in an intuitive and value-added way. The new cricket widget by comes with real-time updates, visualizations, updates, and simple integration to make it a preferred product for operators. STATSCORE Continues to Improve Its Cricket Offering STATSCORE business development Manager said that the launch of cricket data is an important step forward for the company as it allows it to engage with one of the most popular sports in the world. In fact, cricket is the second most popular sport worldwide, and players and operators can now leverage the STATSCORE app to get fast, reliable, real-time data coverage across the board. Stańczak added: With this latest addition, STATSCORE now offers real-time data visualizations for , and the product offering is available in . In terms of cricket coverage, STATSCORE is well aware of what events ought to be featured for the app to have and hold true value with consumers and businesses. Therefore, the company has integrated the and into the app and has extended the language support to now feature Hindi. Cricket is undoubtedly the most popular sport in as of right now, and Indian player bases are a powerful drive for business results for companies. Building an App that Captivates Visualizations Under Pressure STATSCORE VP of product also commented on the launch of the new app and said that her company has worked hard to ensure that the new widget introduced by the firm is fast, flexible, and stable. STATSCORE’s cricket widget will have to hold and perform well under pressure from substantial traffic and interest from players. Gniech-Janicka assured that the widget has what it takes, and it further engages with customers by providing them with captivating visualization that allows bettors and fans to immerse themselves in the experience wherever they are. STATSCORE already has experience covering cricket as well, after the company confirmed that it would be covering the with real-time data.","pubDate":"2023-07-19 07:26:40","image_url":null,"source_id":"gamblingnews","category":["top"],"country":["united states of america"],"language":"english"
                }]}';

            $response = json_decode($api_news, true);

            if ($response && isset($response['results'])) {
                $posts = $response['results'];
                foreach ($posts as $post) {
                    // Access and work with the retrieved posts data
                    ?>
                    <div class="col-md-4 my-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= $post['title'] ?></h5>
                                <p class="card-text"><?= $post['description'] ?></p>
                            </div>
                            <div class="card-footer">
                                <a href="<?= $post['link'] ?>" class="btn btn-primary btn-sm">Read More</a>
                                <p class="text-muted">Author: <?= implode(', ', $post['creator']) ?></p>
                                <p class="text-muted">Publication Date: <?= $post['pubDate'] ?></p>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                // Handle the case when there are no results or invalid response
                echo "No posts found!";
            }
            ?>
        </div>
    </div>
</body>

</html>