<?php


namespace Anexia\ParamParser\Test;


use Anexia\ParamParser\Node\ParamNode;
use Anexia\ParamParser\Node\SequenceNode;
use Anexia\ParamParser\Parser\ParserSyntaxException;
use PHPUnit\Framework\TestCase;

use function Anexia\ParamParser\parse;


class ParseTest extends TestCase
{

    public function testEmpty(): void
    {
        $result = parse('');

        $this->assertCount(0, $result);
    }

    public function testSingleSequenceNode(): void
    {
        $result = parse('this/is/a/test');

        $this->assertCount(1, $result);

        $this->assertInstanceOf(SequenceNode::class, $result[0]);

        $this->assertEquals('this/is/a/test', $result[0]->getSequenceValue());
    }

    public function testSingleParamNode(): void
    {
        $result = parse('{this_is_a_test}');

        $this->assertCount(1, $result);

        $this->assertInstanceOf(ParamNode::class, $result[0]);

        $this->assertEquals('this_is_a_test', $result[0]->getParamName());
        $this->assertEquals(null, $result[0]->getParamType());
        $this->assertEquals([], $result[0]->getParamOptions());
    }

    public function testUntypedParamNode1(): void
    {
        $result = parse('this/{is}/a/test');

        $this->assertCount(3, $result);

        $this->assertInstanceOf(SequenceNode::class, $result[0]);
        $this->assertInstanceOf(ParamNode::class, $result[1]);
        $this->assertInstanceOf(SequenceNode::class, $result[2]);

        $this->assertEquals('this/', $result[0]->getSequenceValue());

        $this->assertEquals('is', $result[1]->getParamName());
        $this->assertEquals(null, $result[1]->getParamType());
        $this->assertEquals([], $result[1]->getParamOptions());

        $this->assertEquals('/a/test', $result[2]->getSequenceValue());
    }

    public function testUntypedParamNode2(): void
    {
        $result = parse('this/{is:}/a/test');

        $this->assertCount(3, $result);

        $this->assertInstanceOf(SequenceNode::class, $result[0]);
        $this->assertInstanceOf(ParamNode::class, $result[1]);
        $this->assertInstanceOf(SequenceNode::class, $result[2]);

        $this->assertEquals('this/', $result[0]->getSequenceValue());

        $this->assertEquals('is', $result[1]->getParamName());
        $this->assertEquals(null, $result[1]->getParamType());
        $this->assertEquals([], $result[1]->getParamOptions());

        $this->assertEquals('/a/test', $result[2]->getSequenceValue());
    }

    public function testTypedParamNode1(): void
    {
        $result = parse('this/{is:string}/a/test');

        $this->assertCount(3, $result);

        $this->assertInstanceOf(SequenceNode::class, $result[0]);
        $this->assertInstanceOf(ParamNode::class, $result[1]);
        $this->assertInstanceOf(SequenceNode::class, $result[2]);

        $this->assertEquals('this/', $result[0]->getSequenceValue());

        $this->assertEquals('is', $result[1]->getParamName());
        $this->assertEquals('string', $result[1]->getParamType());
        $this->assertEquals([], $result[1]->getParamOptions());

        $this->assertEquals('/a/test', $result[2]->getSequenceValue());
    }

    public function testTypedParamNode2(): void
    {
        $result = parse('this/{is:string:}/a/test');

        $this->assertCount(3, $result);

        $this->assertInstanceOf(SequenceNode::class, $result[0]);
        $this->assertInstanceOf(ParamNode::class, $result[1]);
        $this->assertInstanceOf(SequenceNode::class, $result[2]);

        $this->assertEquals('this/', $result[0]->getSequenceValue());

        $this->assertEquals('is', $result[1]->getParamName());
        $this->assertEquals('string', $result[1]->getParamType());
        $this->assertEquals([], $result[1]->getParamOptions());

        $this->assertEquals('/a/test', $result[2]->getSequenceValue());
    }

    public function testTypedParamNodeWithOptions1(): void
    {
        $result = parse('this/{is:string:1,2,3}/a/test');

        $this->assertCount(3, $result);

        $this->assertInstanceOf(SequenceNode::class, $result[0]);
        $this->assertInstanceOf(ParamNode::class, $result[1]);
        $this->assertInstanceOf(SequenceNode::class, $result[2]);

        $this->assertEquals('this/', $result[0]->getSequenceValue());

        $this->assertEquals('is', $result[1]->getParamName());
        $this->assertEquals('string', $result[1]->getParamType());
        $this->assertEquals(['1', '2', '3'], $result[1]->getParamOptions());

        $this->assertEquals('/a/test', $result[2]->getSequenceValue());
    }

    public function testTypedParamNodeWithOptions2(): void
    {
        $result = parse('this/{is:string:1,2,3,}/a/test');

        $this->assertCount(3, $result);

        $this->assertInstanceOf(SequenceNode::class, $result[0]);
        $this->assertInstanceOf(ParamNode::class, $result[1]);
        $this->assertInstanceOf(SequenceNode::class, $result[2]);

        $this->assertEquals('this/', $result[0]->getSequenceValue());

        $this->assertEquals('is', $result[1]->getParamName());
        $this->assertEquals('string', $result[1]->getParamType());
        $this->assertEquals(['1', '2', '3'], $result[1]->getParamOptions());

        $this->assertEquals('/a/test', $result[2]->getSequenceValue());
    }

    public function testSingleSequenceNodeWithEscapedBrackets(): void
    {
        $result = parse('this/\{is:string:1,2,3\}/a/test');

        $this->assertCount(1, $result);

        $this->assertInstanceOf(SequenceNode::class, $result[0]);

        $this->assertEquals('this/{is:string:1,2,3}/a/test', $result[0]->getSequenceValue());
    }

    public function testUntypedParamNodeWithEscapedColon1(): void
    {
        $result = parse('this/{\:}/a/test');

        $this->assertCount(3, $result);

        $this->assertInstanceOf(SequenceNode::class, $result[0]);
        $this->assertInstanceOf(ParamNode::class, $result[1]);
        $this->assertInstanceOf(SequenceNode::class, $result[2]);

        $this->assertEquals('this/', $result[0]->getSequenceValue());

        $this->assertEquals(':', $result[1]->getParamName());
        $this->assertEquals(null, $result[1]->getParamType());
        $this->assertEquals([], $result[1]->getParamOptions());

        $this->assertEquals('/a/test', $result[2]->getSequenceValue());
    }

    public function testUntypedParamNodeWithEscapedColon2(): void
    {
        $result = parse('this/{\::}/a/test');

        $this->assertCount(3, $result);

        $this->assertInstanceOf(SequenceNode::class, $result[0]);
        $this->assertInstanceOf(ParamNode::class, $result[1]);
        $this->assertInstanceOf(SequenceNode::class, $result[2]);

        $this->assertEquals('this/', $result[0]->getSequenceValue());

        $this->assertEquals(':', $result[1]->getParamName());
        $this->assertEquals(null, $result[1]->getParamType());
        $this->assertEquals([], $result[1]->getParamOptions());

        $this->assertEquals('/a/test', $result[2]->getSequenceValue());
    }

    public function testTypedParamNodeWithEscapedColon1(): void
    {
        $result = parse('this/{\::string\:}/a/test');

        $this->assertCount(3, $result);

        $this->assertInstanceOf(SequenceNode::class, $result[0]);
        $this->assertInstanceOf(ParamNode::class, $result[1]);
        $this->assertInstanceOf(SequenceNode::class, $result[2]);

        $this->assertEquals('this/', $result[0]->getSequenceValue());

        $this->assertEquals(':', $result[1]->getParamName());
        $this->assertEquals('string:', $result[1]->getParamType());
        $this->assertEquals([], $result[1]->getParamOptions());

        $this->assertEquals('/a/test', $result[2]->getSequenceValue());
    }

    public function testTypedParamNodeWithEscapedColon2(): void
    {
        $result = parse('this/{\::string\::}/a/test');

        $this->assertCount(3, $result);

        $this->assertInstanceOf(SequenceNode::class, $result[0]);
        $this->assertInstanceOf(ParamNode::class, $result[1]);
        $this->assertInstanceOf(SequenceNode::class, $result[2]);

        $this->assertEquals('this/', $result[0]->getSequenceValue());

        $this->assertEquals(':', $result[1]->getParamName());
        $this->assertEquals('string:', $result[1]->getParamType());
        $this->assertEquals([], $result[1]->getParamOptions());

        $this->assertEquals('/a/test', $result[2]->getSequenceValue());
    }

    public function testTypedParamNodeWithOptionsAndEscapedComma1(): void
    {
        $result = parse('this/{\::string\::1\,2\,3\,}/a/test');

        $this->assertCount(3, $result);

        $this->assertInstanceOf(SequenceNode::class, $result[0]);
        $this->assertInstanceOf(ParamNode::class, $result[1]);
        $this->assertInstanceOf(SequenceNode::class, $result[2]);

        $this->assertEquals('this/', $result[0]->getSequenceValue());

        $this->assertEquals(':', $result[1]->getParamName());
        $this->assertEquals('string:', $result[1]->getParamType());
        $this->assertEquals(['1,2,3,'], $result[1]->getParamOptions());

        $this->assertEquals('/a/test', $result[2]->getSequenceValue());
    }

    public function testTypedParamNodeWithOptionsAndEscapedComma2(): void
    {
        $result = parse('this/{\::string\::1\,2\,3\,,}/a/test');

        $this->assertCount(3, $result);

        $this->assertInstanceOf(SequenceNode::class, $result[0]);
        $this->assertInstanceOf(ParamNode::class, $result[1]);
        $this->assertInstanceOf(SequenceNode::class, $result[2]);

        $this->assertEquals('this/', $result[0]->getSequenceValue());

        $this->assertEquals(':', $result[1]->getParamName());
        $this->assertEquals('string:', $result[1]->getParamType());
        $this->assertEquals(['1,2,3,'], $result[1]->getParamOptions());

        $this->assertEquals('/a/test', $result[2]->getSequenceValue());
    }

    public function testTypedParamNodeWithOptionsAndEscapedBackslash(): void
    {
        $result = parse('this/\\\\{is\\\\:string\\\\:1,2,3\\\\}/a/test');

        $this->assertCount(3, $result);

        $this->assertInstanceOf(SequenceNode::class, $result[0]);
        $this->assertInstanceOf(ParamNode::class, $result[1]);
        $this->assertInstanceOf(SequenceNode::class, $result[2]);

        $this->assertEquals('this/\\', $result[0]->getSequenceValue());

        $this->assertEquals('is\\', $result[1]->getParamName());
        $this->assertEquals('string\\', $result[1]->getParamType());
        $this->assertEquals(['1', '2', '3\\'], $result[1]->getParamOptions());

        $this->assertEquals('/a/test', $result[2]->getSequenceValue());
    }

    public function testMultipleUntypedParamNodes(): void
    {
        $result = parse('{this}/{is}/{a}/{test}');

        $this->assertCount(7, $result);

        $this->assertInstanceOf(ParamNode::class, $result[0]);
        $this->assertInstanceOf(SequenceNode::class, $result[1]);
        $this->assertInstanceOf(ParamNode::class, $result[2]);
        $this->assertInstanceOf(SequenceNode::class, $result[3]);
        $this->assertInstanceOf(ParamNode::class, $result[4]);
        $this->assertInstanceOf(SequenceNode::class, $result[5]);
        $this->assertInstanceOf(ParamNode::class, $result[6]);

        $this->assertEquals('this', $result[0]->getParamName());
        $this->assertEquals(null, $result[0]->getParamType());
        $this->assertEquals([], $result[0]->getParamOptions());

        $this->assertEquals('/', $result[1]->getSequenceValue());

        $this->assertEquals('is', $result[2]->getParamName());
        $this->assertEquals(null, $result[2]->getParamType());
        $this->assertEquals([], $result[2]->getParamOptions());

        $this->assertEquals('/', $result[3]->getSequenceValue());

        $this->assertEquals('a', $result[4]->getParamName());
        $this->assertEquals(null, $result[4]->getParamType());
        $this->assertEquals([], $result[4]->getParamOptions());

        $this->assertEquals('/', $result[5]->getSequenceValue());

        $this->assertEquals('test', $result[6]->getParamName());
        $this->assertEquals(null, $result[6]->getParamType());
        $this->assertEquals([], $result[6]->getParamOptions());
    }

    public function testInvalidSyntaxOnBrackets1(): void
    {
        $this->expectException(ParserSyntaxException::class);
        $this->expectExceptionMessage('Unexpected token \'EOF\' at position \'30\'');

        parse('this/{is:string:1,2,3\}/a/test');
    }

    public function testInvalidSyntaxOnBrackets2(): void
    {
        $this->expectException(ParserSyntaxException::class);
        $this->expectExceptionMessage('Unexpected token \'RC_BRACKET\' at position \'22\'');

        parse('this/\{is:string:1,2,3}/a/test');
    }

    public function testInvalidSyntaxOnBrackets3(): void
    {
        $this->expectException(ParserSyntaxException::class);
        $this->expectExceptionMessage('Unexpected token \'RC_BRACKET\' at position \'6\'');

        parse('this/{}/a/test');
    }

    public function testInvalidSyntaxOnBrackets4(): void
    {
        $this->expectException(ParserSyntaxException::class);
        $this->expectExceptionMessage('Unexpected token \'RC_BRACKET\' at position \'0\'');

        parse('}this/is/a/test');
    }

    public function testInvalidSyntaxOnColon1(): void
    {
        $this->expectException(ParserSyntaxException::class);
        $this->expectExceptionMessage('Unexpected token \'COLON\' at position \'9\'');

        parse('this/{is::}/a/test');
    }

    public function testInvalidSyntaxOnColon2(): void
    {
        $this->expectException(ParserSyntaxException::class);
        $this->expectExceptionMessage('Unexpected token \'COLON\' at position \'21\'');

        parse('this/{is:string:1,2,3:}/a/test');
    }

    public function testInvalidSyntaxOnComma1(): void
    {
        $this->expectException(ParserSyntaxException::class);
        $this->expectExceptionMessage('Unexpected token \'COMMA\' at position \'16\'');

        parse('this/{is:string:,}/a/test');
    }

    public function testInvalidSyntaxOnComma2(): void
    {
        $this->expectException(ParserSyntaxException::class);
        $this->expectExceptionMessage('Unexpected token \'COMMA\' at position \'22\'');

        parse('this/{is:string:1,2,3,,}/a/test');
    }

}
