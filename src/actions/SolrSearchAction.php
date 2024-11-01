/*

add_action('solr_build_document', function(Document $doc, WP_Post $post){
  $url = parse_url(get_permalink($post->ID), PHP_URL_PATH);
  $subsite = Subsites::getSubsiteFromUrl($url);
  if ($subsite instanceof WP_Post) {
    $doc->setField('subsite_i', $subsite->ID);
  }
  return $doc;
}, 10, 2);

add_filter('solr_select_query', function(array $query){
  $subsite = Subsites::getSubsite();
  if ($subsite instanceof WP_Post) {
    $query['filterquery'][] = [
      'key' => 'subsite_i',
      'query' => "subsite_i:$subsite->ID",
    ];
  }
  return $query;
});

*/