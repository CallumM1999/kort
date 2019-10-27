<?php 

    class Template {
        private $data;
        private $template;
        private $methods;
     
        private $methodChecks = [
            "if" => [ "re" => "/@if\((.*?)\)/m", "rpl" => "<?php if (@) : ?>", "innerval" => true ],
            "elseif" => [ "re" => "/@elseif\((.*?)\)/m", "rpl" => "<?php elseif (@): ?>", "innerval" => true ],
            "else" => [ "re" => "/@else/m", "rpl" => "<?php else: ?>", "innerval" => false ],
            "endif" => [ "re" => "/@endif/m", "rpl" => "<?php endif ?>", "innerval" => false ],

            "unless" => [ "re" => "/@unless\((.*?)\)/m", "rpl" => "<?php if(!(@)): ?>", "innerval" => true ],
            "endunless" => [ "re" => "/@endunless/m", "rpl" => "<?php endif; ?>", "innerval" => false ],
            
            "switch" => [ "re" => "/@switch\((.*?)\)/m", "rpl" => "<?php switch(@): ?>", "innerval" => true ],
            "case" => [ "re" => "/@case\((.*?)\)/m", "rpl" => "<?php case @ : ?>", "innerval" => true ],
            "default" => [ "re" => "/@default/m", "rpl" => "<?php default: ?>", "innerval" => false ],
            "endswitch" => [ "re" => "/@endswitch/m", "rpl" => "<?php endswitch; ?>", "innerval" => false ],

            "foreach" => [ "re" => "/@foreach\((.*?)\)/m", "rpl" => "<?php foreach(@): ?>", "innerval" => true ],
            "endforeach" => [ "re" => "/@endforeach/m", "rpl" => "<?php endforeach; ?>", "innerval" => false ],

            "for" => [ "re" => "/@for\((.*)\)/m", "rpl" => "<?php for(@): ?>", "innerval" => true ],
            "endfor" => [ "re" => "/@endfor/m", "rpl" => "<?php endfor; ?>", "innerval" => false ],


            "break" => [ "re" => "/@break/m", "rpl" => "<?php break; ?>", "innerval" => false ],

            "var" => [ "re" => "/\{\{(.*?)\}\}/m", "rpl" => "<?= (isset($@)) ? $@ : \$data['@'] ?>", "innerval" => true ],
        ];
    
        public function __construct($filePath) {
            // Load template contents into string variable
            $currentTemplate = file_get_contents($filePath);

            // Add contents from @extends 
            $matches = $this->templateFindExtends($currentTemplate);
    
            if (sizeof($matches[0]) > 1) throw new Exception('Template can only extend one template');

            if (sizeof($matches[0]) === 1) {
                // render from extended template
                $this->template = $this->buildExtendedTemplate($currentTemplate, $matches);
            } else {
                // Single template, with no parent template
                $this->template = $currentTemplate;
            }

            // Find methods in template
            $this->methods = $this->findMethods();

            // Sort methods by order of position
            $this->sortMethods($this->methods);

            // Replace methods in template with valid php
            $this->template = $this->replaceMethods($this->template, $this->methods, $this->methodChecks);            
            
        }

        private function templateFindExtends($currentTemplate) {
            $matches;
            preg_match_all("/@extends\((.*)\)/m", $currentTemplate, $matches, PREG_OFFSET_CAPTURE);
            return $matches;
        }

        private function buildExtendedTemplate($currentTemplate, $matches) {
            // Name of extended file given
            $baseName = $matches[1][0][0];
            $parentTemplate = $this->loadParentTemplate($baseName);
            /*
                With extends, we instead load the parent template.
                We get the child template and extract any sections, and paste them into the parent.
            */
            // Array of sections, with opening and closing tags
            $childTags = $this->loadChildTags($currentTemplate);
            // Array of sections, with the required loaded markup
            $childSections = $this->loadChildSections($currentTemplate, $childTags);
            $parentTemplate = $this->replaceSections($parentTemplate, $childSections);

            // Find any includes
            $parentTemplate = $this->renderIncludes($parentTemplate);
            
            return $parentTemplate;
        }

        private function renderIncludes($template) {
            $re = "/@include\((.*?)\)/m";

            $newTemplate = $template;

            $noMoreIncludes = false;
            $matches;

            /*

            Find any @includes and insert into template
            Then check if @includes have been added from the last @includes
            Do this until no more can be found

            */
            
            while($noMoreIncludes === false) {
                preg_match_all($re, $newTemplate, $matches, PREG_OFFSET_CAPTURE);
    
                if (sizeof($matches[0]) === 0) {
                    $noMoreIncludes = true;
                    break;
                } 

                foreach($matches[1] as $index => $match) {    
                    $baseName = $match[0];
                    $body = $this->loadTemplate($baseName);
                    $string = $matches[0][$index][0];
                    $newTemplate = str_replace($string, $body, $newTemplate);
                } 
            }

            return $newTemplate;
        }

        private function replaceSections($template, $sections) {
            $newTemplate = $template;
            foreach($sections as $key => $section) {
                $yieldStr = '@yield(\'' . substr($key, 1, -1) . '\')';
                $newTemplate = str_replace($yieldStr, $section, $newTemplate);
            }
        
            return $newTemplate;
        }

        private function loadChildSections($template, $tags) {
            $sections = [];
            foreach($tags as $key => $tag) {
                $newSection = $template;
                $newSection = explode($tag['start'], $newSection)[1];
                $newSection = explode($tag['end'], $newSection)[0];
                $sections[$key] = $newSection;
            }
            return $sections;
        }

        private function loadParentTemplate($baseName) { 
            // Replace . with /
            $baseName = str_replace('.', '/', $baseName);
            // Remove quote marks
            $baseName = substr($baseName, 1, -1);
            // Append file extension
            $baseName .= '.tmp.php';
            $path = APPROOT . '/views/' . $baseName;
            return file_get_contents($path);
        }

        private function loadChildTags($template) {
            $tags = [
                "section" => [ "re" => "/@section\((.*?)\)/m", "type" => "start" ],
                "endsection" => [ "re" => "/@endsection/m", "type" => "end" ]
            ];
            // Load any tags found in template
            $foundTags = $this->findChildTags($tags, $template);

            // Sort tags in order of position
            $foundTags = $this->sortMethods($foundTags);

            // Filter opening tags
            $startTags = array_filter($foundTags, function($tag) {
                return $tag['type'] === 'start';
            });
            // Filter closing tags
            $endTags = array_filter($foundTags, function($tag) {
                return $tag['type'] === 'end';
            });
            // Must be equal number of opening/closing tags
            if (sizeof($startTags) !== sizeof($endTags)) die('start and end sections dont match!');
            // Combine opening and closing tags
            $sectionPairs = $this->combineTagPairs($startTags, $endTags);
            return $sectionPairs;
        }

        private function combineTagPairs($startTags, $endTags) {
            $sectionPairs = [];
            foreach($startTags as $key => $section) {
                // Remove first closing tag
                $endTag = array_shift($endTags);
                $sectionPairs[$section['innerval']] = [
                    "start" => $section['string'],
                    "end" => $endTag['string']
                ];
            }
            return $sectionPairs;
        }

        private function findChildTags($tags, $template) {
            $foundSections = [];
            
            foreach($tags as $name => $tag) {
                $tagMatches = [];
                $re = $tag['re'];
                preg_match_all($re, $template, $tagMatches, PREG_OFFSET_CAPTURE);
                foreach($tagMatches[0] as $index => $match) {
                    $string = $match[0];
                    $position = $match[1];
                    $innerval = isset($tagMatches[1]) ? $tagMatches[1][$index][0] : null;
                    $type = $tags[$name]['type'];
                    $foundSections[] = [
                        "name" => $name,
                        "string" => $string,
                        "position" => $position,
                        "innerval" => $innerval,
                        "type" => $type
                    ];
                }
            }
            return $foundSections;
        }

        private function getTemplatePath($baseName) {
            // Convert . to /
            $baseName = str_replace('.', '/', $baseName);
            // Remove single quotes
            $baseName = substr($baseName, 1, -1);
            // Append file extension
            $baseName .= '.tmp.php';

            return APPROOT . '/views/' . $baseName;
        }

        private function loadTemplate($baseName) {
            $path = $this->getTemplatePath($baseName);
            return file_get_contents($path);
        }

        private function fromExtendedTemplate($currentTemplate, $matches) {
            $parentTemplate = $this->loadTemplate($matches[1][0][0]);

            // Find any layout methods found in parent template
            $layoutMethods = [];

            $layoutChecks = [
                "yield" => [ "re" => "/@yield\((.*)\)/m" ],            
            ];

            foreach($layoutChecks as $key => $check) {
                // Each check is a layout method
                // regex
                $re = $check['re'];

                $matches = [];
                preg_match_all($re, $parentTemplate, $matches, PREG_OFFSET_CAPTURE);

                // Add relevent data to layoutMethods
                foreach($matches[0] as $index => $x) {
                    $obj = [
                        "name" => $key,
                        "position" => $x[1],
                        "contents" => isset($matches[1]) ? $matches[1][$index][0] : null,
                        "value" => $x[0],
                    ];
                    $layoutMethods[] = $obj;
                }
            }

            // Sort methods by order of position
            $this->sortMethods($layoutMethods);

            // Replace layout methods with child content section
            foreach($layoutMethods as $key => $parent) {

                if ($parent['name'] === 'yield') {
                    $open = '@section(' . $parent['contents'] . ')';
                    $close = '@endsection';
                    
                    // Extract section with 'contents' name from child template
                    $child = $currentTemplate; 
                    $child = explode($open, $child)[1];
                    $child = explode($close, $child)[0];

                    $parentTemplate = str_replace($parent['value'], $child, $parentTemplate);
                }
            }

            return $parentTemplate;
        }

        public function replaceMethods($template, $methods, $checks) {
            $newTemplate = $template;

            foreach($methods as $index => $value) {
                $rpl = $checks[$value['name']]['rpl'];
                $match = $value['value'];

                $contents = $value['contents'];
                $contents = trim($contents);
                $contents = ($value['name'] === 'var') ? str_replace('$', '', $contents) : $contents;

                $replacement = ($value['innerval']) ? str_replace('@', $contents, $rpl) : $rpl;
                $newTemplate = str_replace($match, $replacement, $newTemplate);
            };

            return $newTemplate;
        }

        private function sortMethods($methods) {
            $clonedArr = (array)clone(object)$methods;
            usort($clonedArr, function($a, $b) {
                return $a['position'] > $b['position'];
            });
            return $clonedArr;
        }

        private function findMethods() {
            $methods = [];
            foreach($this->methodChecks as $key => $check) {
                $matches = [];
                preg_match_all($check['re'], $this->template, $matches, PREG_OFFSET_CAPTURE);
        
                foreach($matches[0] as $index => $x) {
                    $obj = [
                        "name" => $key,
                        "position" => $x[1],
                        "contents" => isset($matches[1]) ? $matches[1][$index][0] : null,
                        "value" => $x[0],
                        "innerval" => $check['innerval']
                    ];
                    $methods[] = $obj;
                }
            }
            return $methods;
        }

        public function render($data = []) {     
            echo eval(' ?>' . $this->template . '<?php ');
        }
    }

