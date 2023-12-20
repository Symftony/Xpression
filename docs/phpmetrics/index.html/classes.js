var classes = [
    {
        "name": "Symftony\\Xpression\\Parser",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "parse",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getExpression",
                "role": null,
                "public": false,
                "private": true,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "buildComposite",
                "role": null,
                "public": false,
                "private": true,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getNextToken",
                "role": null,
                "public": false,
                "private": true,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 5,
        "nbMethods": 5,
        "nbMethodsPrivate": 3,
        "nbMethodsPublic": 2,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 55,
        "ccn": 51,
        "ccnMethodMax": 43,
        "externals": [
            "Symftony\\Xpression\\Expr\\ExpressionBuilderInterface",
            "Symftony\\Xpression\\Lexer",
            "Symftony\\Xpression\\Exception\\Parser\\InvalidExpressionException",
            "Symftony\\Xpression\\Exception\\Parser\\InvalidExpressionException",
            "Symftony\\Xpression\\Exception\\Parser\\UnsupportedTokenTypeException",
            "Symftony\\Xpression\\Exception\\Parser\\ForbiddenTokenException",
            "Symftony\\Xpression\\Exception\\Parser\\UnexpectedTokenException",
            "LogicException",
            "LogicException",
            "Symftony\\Xpression\\Exception\\Parser\\UnknownCompositeTypeException"
        ],
        "parents": [],
        "implements": [],
        "lcom": 1,
        "length": 389,
        "vocabulary": 57,
        "volume": 2268.99,
        "difficulty": 36.05,
        "effort": 81786.93,
        "level": 0.03,
        "bugs": 0.76,
        "time": 4544,
        "intelligentContent": 62.95,
        "number_operators": 145,
        "number_operands": 244,
        "number_operators_unique": 13,
        "number_operands_unique": 44,
        "cloc": 33,
        "loc": 265,
        "lloc": 232,
        "mi": 44.04,
        "mIwoC": 18.04,
        "commentWeight": 25.99,
        "kanDefect": 1.8,
        "relativeStructuralComplexity": 256,
        "relativeDataComplexity": 0.6,
        "relativeSystemComplexity": 256.6,
        "totalStructuralComplexity": 1280,
        "totalDataComplexity": 3,
        "totalSystemComplexity": 1283,
        "package": "Symftony\\Xpression\\",
        "pageRank": 0.01,
        "afferentCoupling": 0,
        "efferentCoupling": 8,
        "instability": 1,
        "numberOfUnitTests": 8,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\Bridge\\MongoDB\\ExprBuilder",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "getSupportedTokenType",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "parameter",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "string",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "isNull",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "eq",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "neq",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "gt",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "gte",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "lt",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "lte",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "in",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "notIn",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "contains",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "notContains",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "andX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "nandX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "orX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "norX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "xorX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 19,
        "nbMethods": 19,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 19,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 19,
        "ccn": 1,
        "ccnMethodMax": 1,
        "externals": [
            "Symftony\\Xpression\\Expr\\ExpressionBuilderInterface",
            "Symftony\\Xpression\\Exception\\Expr\\UnsupportedExpressionTypeException"
        ],
        "parents": [],
        "implements": [
            "Symftony\\Xpression\\Expr\\ExpressionBuilderInterface"
        ],
        "lcom": 17,
        "length": 94,
        "vocabulary": 23,
        "volume": 425.21,
        "difficulty": 3.57,
        "effort": 1518.62,
        "level": 0.28,
        "bugs": 0.14,
        "time": 84,
        "intelligentContent": 119.06,
        "number_operators": 19,
        "number_operands": 75,
        "number_operators_unique": 2,
        "number_operands_unique": 21,
        "cloc": 1,
        "loc": 81,
        "lloc": 80,
        "mi": 48.51,
        "mIwoC": 39.95,
        "commentWeight": 8.56,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 4,
        "relativeDataComplexity": 6.51,
        "relativeSystemComplexity": 10.51,
        "totalStructuralComplexity": 76,
        "totalDataComplexity": 123.67,
        "totalSystemComplexity": 199.67,
        "package": "Symftony\\Xpression\\Bridge\\MongoDB\\",
        "pageRank": 0.01,
        "afferentCoupling": 0,
        "efferentCoupling": 2,
        "instability": 1,
        "numberOfUnitTests": 3,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\Bridge\\Doctrine\\Common\\ExpressionBuilderAdapter",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getSupportedTokenType",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "parameter",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "string",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "isNull",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "eq",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "neq",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "gt",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "gte",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "lt",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "lte",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "in",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "notIn",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "contains",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "notContains",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "andX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "nandX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "orX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "norX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "xorX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 20,
        "nbMethods": 20,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 20,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 21,
        "ccn": 2,
        "ccnMethodMax": 2,
        "externals": [
            "Symftony\\Xpression\\Expr\\ExpressionBuilderInterface",
            "Doctrine\\Common\\Collections\\ExpressionBuilder",
            "Symftony\\Xpression\\Exception\\Expr\\UnsupportedExpressionTypeException",
            "Symftony\\Xpression\\Exception\\Expr\\UnsupportedExpressionTypeException",
            "Symftony\\Xpression\\Exception\\Expr\\UnsupportedExpressionTypeException",
            "Symftony\\Xpression\\Exception\\Expr\\UnsupportedExpressionTypeException",
            "Symftony\\Xpression\\Exception\\Expr\\UnsupportedExpressionTypeException"
        ],
        "parents": [],
        "implements": [
            "Symftony\\Xpression\\Expr\\ExpressionBuilderInterface"
        ],
        "lcom": 9,
        "length": 92,
        "vocabulary": 15,
        "volume": 359.43,
        "difficulty": 9,
        "effort": 3234.91,
        "level": 0.11,
        "bugs": 0.12,
        "time": 180,
        "intelligentContent": 39.94,
        "number_operators": 20,
        "number_operands": 72,
        "number_operators_unique": 3,
        "number_operands_unique": 12,
        "cloc": 3,
        "loc": 89,
        "lloc": 86,
        "mi": 53.67,
        "mIwoC": 39.64,
        "commentWeight": 14.03,
        "kanDefect": 0.22,
        "relativeStructuralComplexity": 144,
        "relativeDataComplexity": 1.27,
        "relativeSystemComplexity": 145.27,
        "totalStructuralComplexity": 2880,
        "totalDataComplexity": 25.38,
        "totalSystemComplexity": 2905.38,
        "package": "Symftony\\Xpression\\Bridge\\Doctrine\\Common\\",
        "pageRank": 0.01,
        "afferentCoupling": 0,
        "efferentCoupling": 3,
        "instability": 1,
        "numberOfUnitTests": 4,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\Bridge\\Doctrine\\ORM\\ExprAdapter",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": "setter",
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getSupportedTokenType",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "parameter",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "string",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "isNull",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "eq",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "neq",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "gt",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "gte",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "lt",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "lte",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "in",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "notIn",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "contains",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "notContains",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "andX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "nandX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "orX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "norX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "xorX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 20,
        "nbMethods": 19,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 19,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 1,
        "wmc": 20,
        "ccn": 2,
        "ccnMethodMax": 2,
        "externals": [
            "Symftony\\Xpression\\Expr\\ExpressionBuilderInterface",
            "Doctrine\\ORM\\Query\\Expr",
            "Symftony\\Xpression\\Exception\\Expr\\UnsupportedExpressionTypeException",
            "Symftony\\Xpression\\Exception\\Expr\\UnsupportedExpressionTypeException",
            "Symftony\\Xpression\\Exception\\Expr\\UnsupportedExpressionTypeException"
        ],
        "parents": [],
        "implements": [
            "Symftony\\Xpression\\Expr\\ExpressionBuilderInterface"
        ],
        "lcom": 5,
        "length": 97,
        "vocabulary": 13,
        "volume": 358.94,
        "difficulty": 11.55,
        "effort": 4145.79,
        "level": 0.09,
        "bugs": 0.12,
        "time": 230,
        "intelligentContent": 31.08,
        "number_operators": 20,
        "number_operands": 77,
        "number_operators_unique": 3,
        "number_operands_unique": 10,
        "cloc": 0,
        "loc": 85,
        "lloc": 85,
        "mi": 39.75,
        "mIwoC": 39.75,
        "commentWeight": 0,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 196,
        "relativeDataComplexity": 1.17,
        "relativeSystemComplexity": 197.17,
        "totalStructuralComplexity": 3920,
        "totalDataComplexity": 23.33,
        "totalSystemComplexity": 3943.33,
        "package": "Symftony\\Xpression\\Bridge\\Doctrine\\ORM\\",
        "pageRank": 0.01,
        "afferentCoupling": 0,
        "efferentCoupling": 3,
        "instability": 1,
        "numberOfUnitTests": 4,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\Expr\\MapperExpressionBuilder",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getSupportedTokenType",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "parameter",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "string",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "isNull",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "eq",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "neq",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "gt",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "gte",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "lt",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "lte",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "in",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "notIn",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "contains",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "notContains",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "andX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "nandX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "orX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "norX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "xorX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "mapField",
                "role": null,
                "public": false,
                "private": true,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 21,
        "nbMethods": 21,
        "nbMethodsPrivate": 1,
        "nbMethodsPublic": 20,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 26,
        "ccn": 6,
        "ccnMethodMax": 6,
        "externals": [
            "Symftony\\Xpression\\Expr\\ExpressionBuilderInterface",
            "Symftony\\Xpression\\Expr\\ExpressionBuilderInterface"
        ],
        "parents": [],
        "implements": [
            "Symftony\\Xpression\\Expr\\ExpressionBuilderInterface"
        ],
        "lcom": 2,
        "length": 137,
        "vocabulary": 15,
        "volume": 535.24,
        "difficulty": 19.82,
        "effort": 10607.56,
        "level": 0.05,
        "bugs": 0.18,
        "time": 589,
        "intelligentContent": 27.01,
        "number_operators": 28,
        "number_operands": 109,
        "number_operators_unique": 4,
        "number_operands_unique": 11,
        "cloc": 3,
        "loc": 99,
        "lloc": 96,
        "mi": 50.17,
        "mIwoC": 36.85,
        "commentWeight": 13.32,
        "kanDefect": 0.36,
        "relativeStructuralComplexity": 400,
        "relativeDataComplexity": 1.17,
        "relativeSystemComplexity": 401.17,
        "totalStructuralComplexity": 8400,
        "totalDataComplexity": 24.52,
        "totalSystemComplexity": 8424.52,
        "package": "Symftony\\Xpression\\Expr\\",
        "pageRank": 0.01,
        "afferentCoupling": 0,
        "efferentCoupling": 1,
        "instability": 1,
        "numberOfUnitTests": 24,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\Expr\\HtmlExpressionBuilder",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getSupportedTokenType",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "parameter",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "string",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "isNull",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "eq",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "neq",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "gt",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "gte",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "lt",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "lte",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "in",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "notIn",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "contains",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "notContains",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "andX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "nandX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "orX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "norX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "xorX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 20,
        "nbMethods": 20,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 20,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 22,
        "ccn": 3,
        "ccnMethodMax": 3,
        "externals": [
            "Symftony\\Xpression\\Expr\\ExpressionBuilderInterface"
        ],
        "parents": [],
        "implements": [
            "Symftony\\Xpression\\Expr\\ExpressionBuilderInterface"
        ],
        "lcom": 4,
        "length": 138,
        "vocabulary": 37,
        "volume": 718.9,
        "difficulty": 5.07,
        "effort": 3647.38,
        "level": 0.2,
        "bugs": 0.24,
        "time": 203,
        "intelligentContent": 141.7,
        "number_operators": 23,
        "number_operands": 115,
        "number_operators_unique": 3,
        "number_operands_unique": 34,
        "cloc": 14,
        "loc": 101,
        "lloc": 87,
        "mi": 64.55,
        "mIwoC": 37.29,
        "commentWeight": 27.27,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 0,
        "relativeDataComplexity": 20.55,
        "relativeSystemComplexity": 20.55,
        "totalStructuralComplexity": 0,
        "totalDataComplexity": 411,
        "totalSystemComplexity": 411,
        "package": "Symftony\\Xpression\\Expr\\",
        "pageRank": 0.01,
        "afferentCoupling": 0,
        "efferentCoupling": 1,
        "instability": 1,
        "numberOfUnitTests": 2,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\Expr\\ClosureExpressionBuilder",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "getObjectFieldValue",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getSupportedTokenType",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "parameter",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "string",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "isNull",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "eq",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "neq",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "gt",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "gte",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "lt",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "lte",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "in",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "notIn",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "contains",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "notContains",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "andX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "nandX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "orX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "norX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "xorX",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 20,
        "nbMethods": 20,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 20,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 34,
        "ccn": 15,
        "ccnMethodMax": 9,
        "externals": [
            "Symftony\\Xpression\\Expr\\ExpressionBuilderInterface",
            "Symftony\\Xpression\\Expr\\ClosureExpressionBuilder",
            "Symftony\\Xpression\\Expr\\ClosureExpressionBuilder",
            "Symftony\\Xpression\\Expr\\ClosureExpressionBuilder",
            "Symftony\\Xpression\\Expr\\ClosureExpressionBuilder",
            "Symftony\\Xpression\\Expr\\ClosureExpressionBuilder",
            "Symftony\\Xpression\\Expr\\ClosureExpressionBuilder",
            "Symftony\\Xpression\\Expr\\ClosureExpressionBuilder",
            "Symftony\\Xpression\\Expr\\ClosureExpressionBuilder",
            "Symftony\\Xpression\\Expr\\ClosureExpressionBuilder",
            "Symftony\\Xpression\\Expr\\ClosureExpressionBuilder",
            "Symftony\\Xpression\\Expr\\ClosureExpressionBuilder"
        ],
        "parents": [],
        "implements": [
            "Symftony\\Xpression\\Expr\\ExpressionBuilderInterface"
        ],
        "lcom": 20,
        "length": 224,
        "vocabulary": 35,
        "volume": 1148.96,
        "difficulty": 47.86,
        "effort": 54993.37,
        "level": 0.02,
        "bugs": 0.38,
        "time": 3055,
        "intelligentContent": 24,
        "number_operators": 62,
        "number_operands": 162,
        "number_operators_unique": 13,
        "number_operands_unique": 22,
        "cloc": 6,
        "loc": 144,
        "lloc": 138,
        "mi": 45.42,
        "mIwoC": 29.87,
        "commentWeight": 15.55,
        "kanDefect": 1.93,
        "relativeStructuralComplexity": 16,
        "relativeDataComplexity": 6.51,
        "relativeSystemComplexity": 22.51,
        "totalStructuralComplexity": 320,
        "totalDataComplexity": 130.2,
        "totalSystemComplexity": 450.2,
        "package": "Symftony\\Xpression\\Expr\\",
        "pageRank": 0.65,
        "afferentCoupling": 2,
        "efferentCoupling": 3,
        "instability": 0.6,
        "numberOfUnitTests": 4,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\QueryStringParser",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "correctServerQueryString",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "encodeXpression",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 2,
        "nbMethods": 2,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 2,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 4,
        "ccn": 3,
        "ccnMethodMax": 2,
        "externals": [],
        "parents": [],
        "implements": [],
        "lcom": 2,
        "length": 26,
        "vocabulary": 15,
        "volume": 101.58,
        "difficulty": 5,
        "effort": 507.9,
        "level": 0.2,
        "bugs": 0.03,
        "time": 28,
        "intelligentContent": 20.32,
        "number_operators": 6,
        "number_operands": 20,
        "number_operators_unique": 5,
        "number_operands_unique": 10,
        "cloc": 3,
        "loc": 18,
        "lloc": 15,
        "mi": 89.45,
        "mIwoC": 59.89,
        "commentWeight": 29.56,
        "kanDefect": 0.22,
        "relativeStructuralComplexity": 1,
        "relativeDataComplexity": 0.75,
        "relativeSystemComplexity": 1.75,
        "totalStructuralComplexity": 2,
        "totalDataComplexity": 1.5,
        "totalSystemComplexity": 3.5,
        "package": "Symftony\\Xpression\\",
        "pageRank": 0.01,
        "afferentCoupling": 0,
        "efferentCoupling": 0,
        "instability": 0,
        "numberOfUnitTests": 2,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\Lexer",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "getTokenSyntax",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getCatchablePatterns",
                "role": null,
                "public": false,
                "private": true,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getNonCatchablePatterns",
                "role": null,
                "public": false,
                "private": true,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getType",
                "role": null,
                "public": false,
                "private": true,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 4,
        "nbMethods": 4,
        "nbMethodsPrivate": 3,
        "nbMethodsPublic": 1,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 58,
        "ccn": 55,
        "ccnMethodMax": 31,
        "externals": [
            "Doctrine\\Common\\Lexer\\AbstractLexer",
            "Symftony\\Xpression\\Exception\\Lexer\\UnknownTokenTypeException"
        ],
        "parents": [
            "Doctrine\\Common\\Lexer\\AbstractLexer"
        ],
        "implements": [],
        "lcom": 4,
        "length": 494,
        "vocabulary": 89,
        "volume": 3199.01,
        "difficulty": 20.52,
        "effort": 65641.27,
        "level": 0.05,
        "bugs": 1.07,
        "time": 3647,
        "intelligentContent": 155.9,
        "number_operators": 203,
        "number_operands": 291,
        "number_operators_unique": 11,
        "number_operands_unique": 78,
        "cloc": 39,
        "loc": 260,
        "lloc": 221,
        "mi": 45.15,
        "mIwoC": 16.92,
        "commentWeight": 28.23,
        "kanDefect": 2.12,
        "relativeStructuralComplexity": 0,
        "relativeDataComplexity": 4.5,
        "relativeSystemComplexity": 4.5,
        "totalStructuralComplexity": 0,
        "totalDataComplexity": 18,
        "totalSystemComplexity": 18,
        "package": "Symftony\\Xpression\\",
        "pageRank": 0.01,
        "afferentCoupling": 1,
        "efferentCoupling": 2,
        "instability": 0.67,
        "numberOfUnitTests": 4,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\Exception\\Lexer\\LexerException",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [],
        "nbMethodsIncludingGettersSetters": 0,
        "nbMethods": 0,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 0,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 0,
        "ccn": 1,
        "ccnMethodMax": 0,
        "externals": [
            "Exception"
        ],
        "parents": [
            "Exception"
        ],
        "implements": [],
        "lcom": 0,
        "length": 0,
        "vocabulary": 0,
        "volume": 0,
        "difficulty": 0,
        "effort": 0,
        "level": 0,
        "bugs": 0,
        "time": 0,
        "intelligentContent": 0,
        "number_operators": 0,
        "number_operands": 0,
        "number_operators_unique": 0,
        "number_operands_unique": 0,
        "cloc": 0,
        "loc": 4,
        "lloc": 4,
        "mi": 171,
        "mIwoC": 171,
        "commentWeight": 0,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 0,
        "relativeDataComplexity": 0,
        "relativeSystemComplexity": 0,
        "totalStructuralComplexity": 0,
        "totalDataComplexity": 0,
        "totalSystemComplexity": 0,
        "package": "Symftony\\Xpression\\Exception\\Lexer\\",
        "pageRank": 0.02,
        "afferentCoupling": 1,
        "efferentCoupling": 1,
        "instability": 0.5,
        "numberOfUnitTests": 0,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\Exception\\Lexer\\UnknownTokenTypeException",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getTokenType",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 2,
        "nbMethods": 1,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 1,
        "nbMethodsGetter": 1,
        "nbMethodsSetters": 0,
        "wmc": 1,
        "ccn": 1,
        "ccnMethodMax": 1,
        "externals": [
            "Symftony\\Xpression\\Exception\\Lexer\\LexerException",
            "Exception"
        ],
        "parents": [
            "Symftony\\Xpression\\Exception\\Lexer\\LexerException"
        ],
        "implements": [],
        "lcom": 1,
        "length": 10,
        "vocabulary": 7,
        "volume": 28.07,
        "difficulty": 0.75,
        "effort": 21.06,
        "level": 1.33,
        "bugs": 0.01,
        "time": 1,
        "intelligentContent": 37.43,
        "number_operators": 1,
        "number_operands": 9,
        "number_operators_unique": 1,
        "number_operands_unique": 6,
        "cloc": 0,
        "loc": 12,
        "lloc": 12,
        "mi": 66.18,
        "mIwoC": 66.18,
        "commentWeight": 0,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 1,
        "relativeDataComplexity": 1.25,
        "relativeSystemComplexity": 2.25,
        "totalStructuralComplexity": 2,
        "totalDataComplexity": 2.5,
        "totalSystemComplexity": 4.5,
        "package": "Symftony\\Xpression\\Exception\\Lexer\\",
        "pageRank": 0.01,
        "afferentCoupling": 1,
        "efferentCoupling": 2,
        "instability": 0.67,
        "numberOfUnitTests": 0,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\Exception\\Expr\\UnsupportedExpressionTypeException",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getExpressionType",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 2,
        "nbMethods": 1,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 1,
        "nbMethodsGetter": 1,
        "nbMethodsSetters": 0,
        "wmc": 1,
        "ccn": 1,
        "ccnMethodMax": 1,
        "externals": [
            "LogicException",
            "Exception"
        ],
        "parents": [
            "LogicException"
        ],
        "implements": [],
        "lcom": 1,
        "length": 10,
        "vocabulary": 7,
        "volume": 28.07,
        "difficulty": 0.75,
        "effort": 21.06,
        "level": 1.33,
        "bugs": 0.01,
        "time": 1,
        "intelligentContent": 37.43,
        "number_operators": 1,
        "number_operands": 9,
        "number_operators_unique": 1,
        "number_operands_unique": 6,
        "cloc": 0,
        "loc": 12,
        "lloc": 12,
        "mi": 66.18,
        "mIwoC": 66.18,
        "commentWeight": 0,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 1,
        "relativeDataComplexity": 1.25,
        "relativeSystemComplexity": 2.25,
        "totalStructuralComplexity": 2,
        "totalDataComplexity": 2.5,
        "totalSystemComplexity": 4.5,
        "package": "Symftony\\Xpression\\Exception\\Expr\\",
        "pageRank": 0.03,
        "afferentCoupling": 3,
        "efferentCoupling": 2,
        "instability": 0.4,
        "numberOfUnitTests": 0,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\Exception\\Parser\\UnsupportedTokenTypeException",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getSupportedTokenTypes",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 2,
        "nbMethods": 1,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 1,
        "nbMethodsGetter": 1,
        "nbMethodsSetters": 0,
        "wmc": 2,
        "ccn": 2,
        "ccnMethodMax": 2,
        "externals": [
            "Symftony\\Xpression\\Exception\\Parser\\TokenException",
            "Exception"
        ],
        "parents": [
            "Symftony\\Xpression\\Exception\\Parser\\TokenException"
        ],
        "implements": [],
        "lcom": 1,
        "length": 20,
        "vocabulary": 13,
        "volume": 74.01,
        "difficulty": 1.64,
        "effort": 121.11,
        "level": 0.61,
        "bugs": 0.02,
        "time": 7,
        "intelligentContent": 45.23,
        "number_operators": 2,
        "number_operands": 18,
        "number_operators_unique": 2,
        "number_operands_unique": 11,
        "cloc": 7,
        "loc": 20,
        "lloc": 13,
        "mi": 102.02,
        "mIwoC": 62.34,
        "commentWeight": 39.67,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 1,
        "relativeDataComplexity": 1.75,
        "relativeSystemComplexity": 2.75,
        "totalStructuralComplexity": 2,
        "totalDataComplexity": 3.5,
        "totalSystemComplexity": 5.5,
        "package": "Symftony\\Xpression\\Exception\\Parser\\",
        "pageRank": 0.01,
        "afferentCoupling": 1,
        "efferentCoupling": 2,
        "instability": 0.67,
        "numberOfUnitTests": 0,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\Exception\\Parser\\UnexpectedTokenException",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getExpectedTokenTypes",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 2,
        "nbMethods": 1,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 1,
        "nbMethodsGetter": 1,
        "nbMethodsSetters": 0,
        "wmc": 2,
        "ccn": 2,
        "ccnMethodMax": 2,
        "externals": [
            "Symftony\\Xpression\\Exception\\Parser\\TokenException",
            "Exception"
        ],
        "parents": [
            "Symftony\\Xpression\\Exception\\Parser\\TokenException"
        ],
        "implements": [],
        "lcom": 1,
        "length": 20,
        "vocabulary": 13,
        "volume": 74.01,
        "difficulty": 1.64,
        "effort": 121.11,
        "level": 0.61,
        "bugs": 0.02,
        "time": 7,
        "intelligentContent": 45.23,
        "number_operators": 2,
        "number_operands": 18,
        "number_operators_unique": 2,
        "number_operands_unique": 11,
        "cloc": 7,
        "loc": 20,
        "lloc": 13,
        "mi": 102.02,
        "mIwoC": 62.34,
        "commentWeight": 39.67,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 1,
        "relativeDataComplexity": 1.75,
        "relativeSystemComplexity": 2.75,
        "totalStructuralComplexity": 2,
        "totalDataComplexity": 3.5,
        "totalSystemComplexity": 5.5,
        "package": "Symftony\\Xpression\\Exception\\Parser\\",
        "pageRank": 0.01,
        "afferentCoupling": 1,
        "efferentCoupling": 2,
        "instability": 0.67,
        "numberOfUnitTests": 0,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\Exception\\Parser\\ParserException",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [],
        "nbMethodsIncludingGettersSetters": 0,
        "nbMethods": 0,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 0,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 0,
        "ccn": 1,
        "ccnMethodMax": 0,
        "externals": [
            "Exception"
        ],
        "parents": [
            "Exception"
        ],
        "implements": [],
        "lcom": 0,
        "length": 0,
        "vocabulary": 0,
        "volume": 0,
        "difficulty": 0,
        "effort": 0,
        "level": 0,
        "bugs": 0,
        "time": 0,
        "intelligentContent": 0,
        "number_operators": 0,
        "number_operands": 0,
        "number_operators_unique": 0,
        "number_operands_unique": 0,
        "cloc": 0,
        "loc": 4,
        "lloc": 4,
        "mi": 171,
        "mIwoC": 171,
        "commentWeight": 0,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 0,
        "relativeDataComplexity": 0,
        "relativeSystemComplexity": 0,
        "totalStructuralComplexity": 0,
        "totalDataComplexity": 0,
        "totalSystemComplexity": 0,
        "package": "Symftony\\Xpression\\Exception\\Parser\\",
        "pageRank": 0.03,
        "afferentCoupling": 2,
        "efferentCoupling": 1,
        "instability": 0.33,
        "numberOfUnitTests": 0,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\Exception\\Parser\\InvalidExpressionException",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getInput",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 2,
        "nbMethods": 1,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 1,
        "nbMethodsGetter": 1,
        "nbMethodsSetters": 0,
        "wmc": 2,
        "ccn": 2,
        "ccnMethodMax": 2,
        "externals": [
            "RuntimeException",
            "Exception"
        ],
        "parents": [
            "RuntimeException"
        ],
        "implements": [],
        "lcom": 1,
        "length": 15,
        "vocabulary": 10,
        "volume": 49.83,
        "difficulty": 1.63,
        "effort": 80.97,
        "level": 0.62,
        "bugs": 0.02,
        "time": 4,
        "intelligentContent": 30.66,
        "number_operators": 2,
        "number_operands": 13,
        "number_operators_unique": 2,
        "number_operands_unique": 8,
        "cloc": 0,
        "loc": 12,
        "lloc": 12,
        "mi": 64.3,
        "mIwoC": 64.3,
        "commentWeight": 0,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 1,
        "relativeDataComplexity": 1.5,
        "relativeSystemComplexity": 2.5,
        "totalStructuralComplexity": 2,
        "totalDataComplexity": 3,
        "totalSystemComplexity": 5,
        "package": "Symftony\\Xpression\\Exception\\Parser\\",
        "pageRank": 0.01,
        "afferentCoupling": 1,
        "efferentCoupling": 2,
        "instability": 0.67,
        "numberOfUnitTests": 0,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\Exception\\Parser\\SyntaxErrorException",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 1,
        "nbMethods": 1,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 1,
        "nbMethodsGetter": 0,
        "nbMethodsSetters": 0,
        "wmc": 2,
        "ccn": 2,
        "ccnMethodMax": 2,
        "externals": [
            "Symftony\\Xpression\\Exception\\Parser\\ParserException",
            "Exception"
        ],
        "parents": [
            "Symftony\\Xpression\\Exception\\Parser\\ParserException"
        ],
        "implements": [],
        "lcom": 1,
        "length": 8,
        "vocabulary": 5,
        "volume": 18.58,
        "difficulty": 0,
        "effort": 0,
        "level": 1.25,
        "bugs": 0.01,
        "time": 0,
        "intelligentContent": 23.22,
        "number_operators": 0,
        "number_operands": 8,
        "number_operators_unique": 0,
        "number_operands_unique": 5,
        "cloc": 0,
        "loc": 8,
        "lloc": 8,
        "mi": 71.15,
        "mIwoC": 71.15,
        "commentWeight": 0,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 1,
        "relativeDataComplexity": 1.5,
        "relativeSystemComplexity": 2.5,
        "totalStructuralComplexity": 1,
        "totalDataComplexity": 1.5,
        "totalSystemComplexity": 2.5,
        "package": "Symftony\\Xpression\\Exception\\Parser\\",
        "pageRank": 0.02,
        "afferentCoupling": 1,
        "efferentCoupling": 2,
        "instability": 0.67,
        "numberOfUnitTests": 0,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\Exception\\Parser\\TokenException",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getToken",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 2,
        "nbMethods": 1,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 1,
        "nbMethodsGetter": 1,
        "nbMethodsSetters": 0,
        "wmc": 1,
        "ccn": 1,
        "ccnMethodMax": 1,
        "externals": [
            "Symftony\\Xpression\\Exception\\Parser\\SyntaxErrorException",
            "Exception"
        ],
        "parents": [
            "Symftony\\Xpression\\Exception\\Parser\\SyntaxErrorException"
        ],
        "implements": [],
        "lcom": 1,
        "length": 10,
        "vocabulary": 7,
        "volume": 28.07,
        "difficulty": 0.75,
        "effort": 21.06,
        "level": 1.33,
        "bugs": 0.01,
        "time": 1,
        "intelligentContent": 37.43,
        "number_operators": 1,
        "number_operands": 9,
        "number_operators_unique": 1,
        "number_operands_unique": 6,
        "cloc": 6,
        "loc": 18,
        "lloc": 12,
        "mi": 105.18,
        "mIwoC": 66.18,
        "commentWeight": 38.99,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 1,
        "relativeDataComplexity": 1.5,
        "relativeSystemComplexity": 2.5,
        "totalStructuralComplexity": 2,
        "totalDataComplexity": 3,
        "totalSystemComplexity": 5,
        "package": "Symftony\\Xpression\\Exception\\Parser\\",
        "pageRank": 0.03,
        "afferentCoupling": 3,
        "efferentCoupling": 2,
        "instability": 0.4,
        "numberOfUnitTests": 0,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\Exception\\Parser\\UnknownCompositeTypeException",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getUnknownType",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 2,
        "nbMethods": 1,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 1,
        "nbMethodsGetter": 1,
        "nbMethodsSetters": 0,
        "wmc": 2,
        "ccn": 2,
        "ccnMethodMax": 2,
        "externals": [
            "Symftony\\Xpression\\Exception\\Parser\\ParserException",
            "Exception"
        ],
        "parents": [
            "Symftony\\Xpression\\Exception\\Parser\\ParserException"
        ],
        "implements": [],
        "lcom": 1,
        "length": 13,
        "vocabulary": 9,
        "volume": 41.21,
        "difficulty": 0.75,
        "effort": 30.91,
        "level": 1.33,
        "bugs": 0.01,
        "time": 2,
        "intelligentContent": 54.95,
        "number_operators": 1,
        "number_operands": 12,
        "number_operators_unique": 1,
        "number_operands_unique": 8,
        "cloc": 0,
        "loc": 12,
        "lloc": 12,
        "mi": 64.88,
        "mIwoC": 64.88,
        "commentWeight": 0,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 1,
        "relativeDataComplexity": 1.5,
        "relativeSystemComplexity": 2.5,
        "totalStructuralComplexity": 2,
        "totalDataComplexity": 3,
        "totalSystemComplexity": 5,
        "package": "Symftony\\Xpression\\Exception\\Parser\\",
        "pageRank": 0.01,
        "afferentCoupling": 1,
        "efferentCoupling": 2,
        "instability": 0.67,
        "numberOfUnitTests": 0,
        "violations": {}
    },
    {
        "name": "Symftony\\Xpression\\Exception\\Parser\\ForbiddenTokenException",
        "interface": false,
        "abstract": false,
        "final": false,
        "methods": [
            {
                "name": "__construct",
                "role": null,
                "public": true,
                "private": false,
                "_type": "Hal\\Metric\\FunctionMetric"
            },
            {
                "name": "getAllowedTokenTypes",
                "role": "getter",
                "_type": "Hal\\Metric\\FunctionMetric"
            }
        ],
        "nbMethodsIncludingGettersSetters": 2,
        "nbMethods": 1,
        "nbMethodsPrivate": 0,
        "nbMethodsPublic": 1,
        "nbMethodsGetter": 1,
        "nbMethodsSetters": 0,
        "wmc": 2,
        "ccn": 2,
        "ccnMethodMax": 2,
        "externals": [
            "Symftony\\Xpression\\Exception\\Parser\\TokenException",
            "Exception"
        ],
        "parents": [
            "Symftony\\Xpression\\Exception\\Parser\\TokenException"
        ],
        "implements": [],
        "lcom": 1,
        "length": 20,
        "vocabulary": 13,
        "volume": 74.01,
        "difficulty": 1.64,
        "effort": 121.11,
        "level": 0.61,
        "bugs": 0.02,
        "time": 7,
        "intelligentContent": 45.23,
        "number_operators": 2,
        "number_operands": 18,
        "number_operators_unique": 2,
        "number_operands_unique": 11,
        "cloc": 7,
        "loc": 20,
        "lloc": 13,
        "mi": 102.02,
        "mIwoC": 62.34,
        "commentWeight": 39.67,
        "kanDefect": 0.15,
        "relativeStructuralComplexity": 1,
        "relativeDataComplexity": 1.75,
        "relativeSystemComplexity": 2.75,
        "totalStructuralComplexity": 2,
        "totalDataComplexity": 3.5,
        "totalSystemComplexity": 5.5,
        "package": "Symftony\\Xpression\\Exception\\Parser\\",
        "pageRank": 0.01,
        "afferentCoupling": 1,
        "efferentCoupling": 2,
        "instability": 0.67,
        "numberOfUnitTests": 0,
        "violations": {}
    }
]