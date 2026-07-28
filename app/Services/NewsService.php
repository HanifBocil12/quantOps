public function getNews(int $limit = 20): array
{
    $allNews = array_merge(
        $this->getRssNews(),
        Cache::get('telegram_news', [])
    );

    $allNews = $this->filterNews($allNews);
    $allNews = $this->categorizeNews($allNews);

    usort($allNews, fn($a, $b) => $b['published'] - $a['published']);

    return array_slice($allNews, 0, $limit);
}

/**
 * Kelompokkan crypto news jadi 2: onchain_alert (whale/wallet movement)
 * vs general (artikel/analisis biasa).
 */
protected array $onchainAlertSources = [
    'whale_alert_io',
];

protected function categorizeNews(array $news): array
{
    foreach ($news as &$item) {
        $item['category'] = in_array($item['source'], $this->onchainAlertSources)
            ? 'onchain_alert'
            : 'general';
    }

    return $news;
}

/**
 * Ambil crypto news, udah dipisah ke 2 grup.
 */
public function getCryptoNewsGrouped(int $limitPerGroup = 10): array
{
    $allNews = array_merge(
        $this->getRssNews(),
        Cache::get('telegram_news', [])
    );

    $allNews = $this->filterNews($allNews);
    $allNews = $this->categorizeNews($allNews);

    usort($allNews, fn($a, $b) => $b['published'] - $a['published']);

    $onchainAlert = array_values(array_filter($allNews, fn($n) => $n['category'] === 'onchain_alert'));
    $general = array_values(array_filter($allNews, fn($n) => $n['category'] === 'general'));

    return [
        'onchain_alert' => array_slice($onchainAlert, 0, $limitPerGroup),
        'general'       => array_slice($general, 0, $limitPerGroup),
    ];
}