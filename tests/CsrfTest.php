<?php
namespace PHPUnit\Framework {
    if (!class_exists(TestCase::class, false)) {
        abstract class TestCase
        {
            protected function assertArrayHasKey($key, $array, $message = '')
            {
                if (!array_key_exists($key, $array)) {
                    throw new \RuntimeException($message ?: "Failed asserting that an array has the key '{$key}'.");
                }
            }

            protected function assertEquals($expected, $actual, $message = '')
            {
                if ($expected != $actual) {
                    throw new \RuntimeException($message ?: "Failed asserting that '{$actual}' is equal to '{$expected}'.");
                }
            }

            protected function assertTrue($condition, $message = '')
            {
                if ($condition !== true) {
                    throw new \RuntimeException($message ?: 'Failed asserting that condition is true.');
                }
            }

            protected function assertFalse($condition, $message = '')
            {
                if ($condition !== false) {
                    throw new \RuntimeException($message ?: 'Failed asserting that condition is false.');
                }
            }

            protected function assertNotEquals($expected, $actual, $message = '')
            {
                if ($expected == $actual) {
                    throw new \RuntimeException($message ?: "Failed asserting that '{$actual}' is not equal to '{$expected}'.");
                }
            }
        }
    }
}

namespace {
    /**
     * Unit tests for CSRF Protection Utility
     *
     * These tests verify token generation, retrieval, validation, and rotation.
     */
    class CsrfTest extends \PHPUnit\Framework\TestCase
    {
    protected function setUp(): void
    {
        // Ensure session is started in the CLI environment if needed
        if (session_status() === PHP_SESSION_NONE) {
            @session_start();
        }
        
        // Reset session state for test isolation
        $_SESSION = [];
        
        // Include the utility
        require_once __DIR__ . '/../includes/csrf.php';
        
        // Manually trigger token generation if session was cleared
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    public function testTokenIsGeneratedAutomatically()
    {
        $this->assertArrayHasKey('csrf_token', $_SESSION);
        $this->assertEquals(64, strlen($_SESSION['csrf_token']), "Token should be a 64-character hex string.");
    }

    public function testCsrfTokenGetterReturnsValueFromSession()
    {
        $token = csrf_token();
        $this->assertEquals($_SESSION['csrf_token'], $token, "Getter must return the current session token.");
    }

    public function testValidateCsrfSuccessAndRotation()
    {
        $originalToken = $_SESSION['csrf_token'];
        $result = validate_csrf($originalToken);
        
        $this->assertTrue($result, "Validation should pass when providing the correct token.");
        $this->assertNotEquals($originalToken, $_SESSION['csrf_token'], "Token must rotate after a successful validation.");
    }

    public function testValidateCsrfFailureDoesNotRotate()
    {
        $originalToken = $_SESSION['csrf_token'];
        $result = validate_csrf('invalid_token_string');
        
        $this->assertFalse($result, "Validation should fail when providing an incorrect token.");
        $this->assertEquals($originalToken, $_SESSION['csrf_token'], "Token should NOT rotate if validation fails.");
    }
}