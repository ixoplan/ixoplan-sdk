<?php

use Ixolit\Dislo\Redirector\Rules\Actions\NoRedirection;
use Ixolit\Dislo\Redirector\Rules\Actions\RedirectToUrl;
use Ixolit\Dislo\Redirector\Rules\Actions\SetCookie;
use Ixolit\Dislo\Redirector\Rules\Conditions\UrlCheck;
use Ixolit\Dislo\Redirector\Rules\Rule;
use Ixolit\Dislo\Redirector\Rules\RuleConditionNode;
use Ixolit\Dislo\Redirector\RulesParser;

/**
 * Class RulesParserTest
 * @package Ixolit\Dislo\Redirector
 */
class RulesParserTest extends \PHPUnit_Framework_TestCase
{

    public function testEmptyRulesArrayJson() {

        $jsonExample =
            '{
                "redirectorRules": []
            }';

        $rulesParser = new RulesParser();
        $rules = $rulesParser->buildRulesFromJson($jsonExample);

        $this->assertCount(0, $rules);

    }

    public function testEmptyRulesJson() {

        $jsonExample =
            '{
                "redirectorRules": [
                    {
                        "name": "Rule1",
                        "ruleNodes": []
                    },
                    {
                        "name": "Rule2",
                        "ruleNodes": []
                    }
                ]
            }';

        $rulesParser = new RulesParser();
        $rules = $rulesParser->buildRulesFromJson($jsonExample);

        $this->assertCount(2, $rules);

        foreach ($rules as $rule) {
            $this->assertInstanceOf(Rule::class, $rule);
        }

    }

    public function testRulesJson1() {

        $jsonExample =
            '{
                "redirectorRules": [
                    {
                        "name": "Rule1",
                        "ruleNodes": {
                            "type": "condition",
                            "next": {
                                "type": "SetCookie",
                                "data": {
                                    "cookieName": "cookieName",
                                    "cookieValue": "cookieValue",
                                    "maxAge": "2700",
                                    "Path": "\/",
                                    "httpOnly": "true",
                                    "requireSSL": "true"
                                }
                            },
                            "matching": "AND",
                            "conditions": [
                                {
                                    "type": "UrlCheck",
                                    "data": {
                                        "comparator": "regex",
                                        "value": "#test#i"
                                    }
                                }
                            ],
                            "then": {
                                "type": "RedirectToUrl",
                                "data": {
                                    "url": "http:\/\/url-example.com",
                                    "statusCode": 302
                                }
                            },
                            "else": {
                                "type": "NoRedirection"
                            }
                        }
                    }
                ]
            }';

        $rulesParser = new RulesParser();
        $rules = $rulesParser->buildRulesFromJson($jsonExample);

        $this->assertCount(1, $rules);
        $rule = $rules[0];

        $this->assertInstanceOf(RuleConditionNode::class, $rule->getRootRuleNode());

        /** @var RuleConditionNode $ruleConditionNode */
        $ruleConditionNode = $rule->getRootRuleNode();
        $this->assertInstanceOf(UrlCheck::class, $ruleConditionNode->getConditions()[0]);
        $this->assertInstanceOf(RedirectToUrl::class, $ruleConditionNode->getThen());
        $this->assertInstanceOf(NoRedirection::class, $ruleConditionNode->getElse());
        $this->assertInstanceOf(SetCookie::class, $ruleConditionNode->getNext());

    }

    public function testRulesJson2() {

        $jsonExample =
            '{
                "redirectorRules": [
                    {
                        "name": "Rule1",
                        "ruleNodes": {
                            "type": "condition",
                            "next": {
                                "type": "NoRedirection"
                            },
                            "matching": "AND",
                            "conditions": [
                                {
                                    "type": "UrlCheck",
                                    "data": {
                                        "comparator": "starts_with",
                                        "value": "url_example"
                                    }
                                },
                                {
                                    "type": "UrlSchemeCheck",
                                    "data": {
                                        "comparator": "equals",
                                        "value": "https"
                                    }
                                },
                                {
                                    "type": "UrlHostCheck",
                                    "data": {
                                        "comparator": "contains",
                                        "value": "host_example"
                                    }
                                },
                                {
                                    "type": "UrlPathCheck",
                                    "data": {
                                        "comparator": "equals",
                                        "value": "path_example"
                                    }
                                },
                                {
                                    "type": "CountryCheck",
                                    "data": {
                                        "comparator": "equals",
                                        "country": "AT"
                                    }
                                },
                                {
                                    "type": "RandomLoadBalancer",
                                    "data": {
                                        "comparator": "lower_than",
                                        "value": "50"
                                    }
                                },
                                {
                                    "type": "RequestParameterCheck",
                                    "data": {
                                        "requestParameterName": "value1",
                                        "comparator": "equals",
                                        "requestParameterValue": "requestParametername1"
                                    }
                                },
                                {
                                    "type": "CookieCheck",
                                    "data": {
                                        "comparator": "equals",
                                        "cookieName": "cookieName1",
                                        "cookieValue": "cookieValue1"
                                    }
                                }
                            ],
                            "then": {
                                "type": "SetCookie",
                                "data": {
                                    "cookieName": "name_of_new_cookie_to_set",
                                    "cookieValue": "new_cookie_value",
                                    "maxAge": "2700",
                                    "Path": "\/",
                                    "httpOnly": "true",
                                    "requireSSL": "true"
                                },
                                "next": {
                                    "type": "RedirectToUrl",
                                    "data": {
                                        "url": "http:\/\/www.test.ixolit.com",
                                        "statusCode": 302
                                    }
                                }
                            },
                            "else": null
                        }
                    }
                ]
            }';

        $rulesParser = new RulesParser();
        $rules = $rulesParser->buildRulesFromJson($jsonExample);

        $this->assertCount(1, $rules);
        $rule = $rules[0];

        $this->assertInstanceOf(RuleConditionNode::class, $rule->getRootRuleNode());

        /** @var RuleConditionNode $ruleConditionNode */
        $ruleConditionNode = $rule->getRootRuleNode();

        $this->assertCount(8, $ruleConditionNode->getConditions());

        $this->assertInstanceOf(NoRedirection::class, $ruleConditionNode->getNext());

        $this->assertInstanceOf(SetCookie::class, $ruleConditionNode->getThen());

        $this->assertInstanceOf(RedirectToUrl::class, $ruleConditionNode->getThen()->getNext());

    }


    public function testRulesJson3() {

        $jsonExample =
            '{
                "redirectorRules": [
                    {
                        "name": "TestRule",
                        "ruleNodes": {
                            "type": "condition",
                            "next": {
                                "type": "condition",
                                "next": {
                                    "type": "condition",
                                    "next": {
                                        "type": "condition",
                                        "next": {
                                            "type": "condition",
                                            "next": {
                                                "type": "condition",
                                                "matching": "AND",
                                                "conditions": [
                                                    {
                                                        "type": "CountryCheck",
                                                        "data": {
                                                            "comparator": "not_equals",
                                                            "country": "AO"
                                                        }
                                                    }
                                                ],
                                                "then": null,
                                                "else": null
                                            },
                                            "matching": "AND",
                                            "conditions": [
                                                {
                                                    "type": "RandomLoadBalancer",
                                                    "data": {
                                                        "comparator": "lower_than",
                                                        "value": "50"
                                                    }
                                                }
                                            ],
                                            "then": null,
                                            "else": null
                                        },
                                        "matching": "AND",
                                        "conditions": [
                                            {
                                                "type": "CountryCheck",
                                                "data": {
                                                    "comparator": "equals",
                                                    "country": "AT"
                                                }
                                            }
                                        ],
                                        "then": null,
                                        "else": null
                                    },
                                    "matching": "AND",
                                    "conditions": [
                                        {
                                            "type": "UrlHostCheck",
                                            "data": {
                                                "comparator": "contains",
                                                "value": "test"
                                            }
                                        }
                                    ],
                                    "then": null,
                                    "else": null
                                },
                                "matching": "AND",
                                "conditions": [
                                    {
                                        "type": "UrlSchemeCheck",
                                        "data": {
                                            "comparator": "equals",
                                            "value": "https"
                                        }
                                    }
                                ],
                                "then": null,
                                "else": null
                            },
                            "matching": "AND",
                            "conditions": [
                                {
                                    "type": "UrlCheck",
                                    "data": {
                                        "comparator": "starts_with",
                                        "value": "3"
                                    }
                                }
                            ],
                            "then": null,
                            "else": null
                        }
                    },
                    {
                        "name": "TestRule2",
                        "ruleNodes": {
                            "type": "condition",
                            "matching": "AND",
                            "conditions": [
                                {
                                    "type": "UrlSchemeCheck",
                                    "data": {
                                        "comparator": "equals",
                                        "value": "https"
                                    }
                                }
                            ],
                            "then": null,
                            "else": null
                        }
                    }
                ]
            }';

        $rulesParser = new RulesParser();
        $rules = $rulesParser->buildRulesFromJson($jsonExample);

        $this->assertCount(2, $rules);
        $rule = $rules[0];

        $this->assertInstanceOf(RuleConditionNode::class, $rule->getRootRuleNode());

        /** @var RuleConditionNode $ruleConditionNode */
        $ruleConditionNode = $rule->getRootRuleNode();

        $this->assertCount(1, $ruleConditionNode->getConditions());

    }

    public function testRulesJson4() {

        $jsonExample =
            '{
                "redirectorRules": [
                    {
                        "name": "TestRule",
                        "ruleNodes": {
                            "type": "condition",
                            "matching": "AND",
                            "conditions": [
                                {
                                    "type": "HeaderCheck",
                                    "data": {
                                        "comparator": "exists",
                                        "headerName": "headerName1",
                                        "headerValue": null
                                    }
                                },
                                {
                                    "type": "HeaderCheck",
                                    "data": {
                                        "comparator": "contains",
                                        "headerName": "headerName2",
                                        "headerValue": "testValue2"
                                    }
                                }
                            ],
                            "then": null,
                            "else": null
                        }
                    }
                ]
            }';

        $rulesParser = new RulesParser();
        $rules = $rulesParser->buildRulesFromJson($jsonExample);

        $this->assertCount(1, $rules);
        $rule = $rules[0];

        $this->assertInstanceOf(RuleConditionNode::class, $rule->getRootRuleNode());

        /** @var RuleConditionNode $ruleConditionNode */
        $ruleConditionNode = $rule->getRootRuleNode();

        $this->assertCount(2, $ruleConditionNode->getConditions());

    }

}