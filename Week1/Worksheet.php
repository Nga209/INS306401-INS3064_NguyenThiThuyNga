<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INS3064 Active Learning Worksheet - Session 00 & 01</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Calibri', 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f5f5f5;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 50px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #667eea;
            font-size: 26px;
            margin-bottom: 5px;
        }

        .header h2 {
            color: #764ba2;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .student-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
            padding: 15px;
            background: #f9f9f9;
            border-left: 4px solid #667eea;
        }

        .info-field {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .info-field label {
            font-weight: bold;
            width: 110px;
            color: #667eea;
        }

        .info-field input {
            flex: 1;
            border: none;
            border-bottom: 1px solid #ddd;
            padding: 5px;
        }

        .section {
            margin-bottom: 40px;
        }

        .section-header {
            background: #667eea;
            color: white;
            padding: 12px 15px;
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 20px;
            border-radius: 3px;
        }

        .section h3 {
            color: #667eea;
            font-size: 15px;
            margin-top: 20px;
            margin-bottom: 12px;
            padding-bottom: 8px;
            border-bottom: 2px solid #667eea;
        }

        .section h4 {
            color: #764ba2;
            font-size: 13px;
            margin-top: 15px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .section p {
            margin-bottom: 12px;
            text-align: justify;
        }

        .key-concept {
            background: #e8f4f8;
            border-left: 4px solid #667eea;
            padding: 12px;
            margin: 12px 0;
            border-radius: 3px;
        }

        .key-concept strong {
            color: #667eea;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        table th {
            background: #667eea;
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            font-size: 13px;
        }

        table td {
            padding: 10px 12px;
            border: 1px solid #ddd;
            font-size: 13px;
        }

        table tr:nth-child(even) {
            background: #f9f9f9;
        }

        .procedure {
            background: #f9f9f9;
            padding: 15px;
            border-left: 3px solid #764ba2;
            margin: 15px 0;
            border-radius: 3px;
        }

        .procedure ol {
            margin-left: 20px;
        }

        .procedure li {
            margin-bottom: 8px;
        }

        .starter-code {
            background: #2d3748;
            color: #e2e8f0;
            padding: 15px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
            overflow-x: auto;
            margin: 15px 0;
        }

        .answer-space {
            min-height: 60px;
            border-bottom: 1px dotted #ddd;
            margin: 12px 0;
            padding: 5px 0;
        }

        .checkbox {
            display: inline-block;
            width: 18px;
            height: 18px;
            border: 1px solid #333;
            margin-right: 8px;
            vertical-align: middle;
        }

        .evidence-box {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 12px;
            margin: 15px 0;
            border-radius: 3px;
        }

        .evidence-box strong {
            color: #856404;
        }

        .learning-outcome {
            background: #d4edda;
            border-left: 4px solid #28a745;
            padding: 12px;
            margin: 15px 0;
            border-radius: 3px;
        }

        .learning-outcome strong {
            color: #155724;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .page-break {
            page-break-after: always;
            margin-bottom: 30px;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }
            .container {
                max-width: 100%;
                box-shadow: none;
                padding: 0;
            }
        }

        .rubric-table {
            width: 100%;
            margin: 15px 0;
        }

        .rubric-table td {
            padding: 8px;
            font-size: 12px;
        }

        .score-cell {
            text-align: center;
            width: 60px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <h1>ACTIVE LEARNING WORKSHEET</h1>
            <h2>Session 00 & Session 01: Introduction to Web Development with PHP</h2>
            <p>INS3064: Multimedia Design & Web Development</p>
        </div>

        <!-- STUDENT INFORMATION -->
        <div class="student-info">
            <div class="info-field">
                <label>Student Name:</label>
                <input type="text" placeholder="________________________">
            </div>
            <div class="info-field">
                <label>Student ID:</label>
                <input type="text" placeholder="_______________">
            </div>
            <div class="info-field">
                <label>Date:</label>
                <input type="text" placeholder="________________________">
            </div>
            <div class="info-field">
                <label>Class:</label>
                <input type="text" placeholder="_______________">
            </div>
        </div>

        <!-- SECTION 1: CORE THEORY (KEY CONCEPTS) -->
        <div class="section">
            <div class="section-header">SECTION 1: CORE THEORY (KEY CONCEPTS)</div>

            <h3>1.1 What is PHP?</h3>
            <p>PHP stands for <strong>PHP: Hypertext Preprocessor</strong> (a recursive acronym). It is a server-side scripting language designed specifically for web development. Unlike HTML and CSS which run in the browser, PHP executes on the web server before sending content to the user's browser.</p>

            <div class="key-concept">
                <strong>Key Point:</strong> PHP is server-side, meaning users cannot see the PHP code—only the HTML output it generates. This makes it ideal for processing data, validating forms, and accessing databases securely.
            </div>

            <h3>1.2 Why Learn PHP?</h3>
            <table>
                <tr>
                    <th>Reason</th>
                    <th>Explanation</th>
                </tr>
                <tr>
                    <td><strong>Market Dominance</strong></td>
                    <td>77% of websites with known server-side language use PHP (WordPress, Facebook, Wikipedia)</td>
                </tr>
                <tr>
                    <td><strong>Easy to Learn</strong></td>
                    <td>Simple syntax similar to C and Perl; excellent documentation available</td>
                </tr>
                <tr>
                    <td><strong>Cost-Effective</strong></td>
                    <td>Free and open-source; no licensing fees required</td>
                </tr>
                <tr>
                    <td><strong>Database Integration</strong></td>
                    <td>Works seamlessly with MySQL and other databases</td>
                </tr>
                <tr>
                    <td><strong>Large Community</strong></td>
                    <td>Extensive resources, forums, and support available</td>
                </tr>
            </table>

            <h3>1.3 PHP Basic Syntax Requirements</h3>
            <p>PHP code must follow specific formatting rules:</p>
            <div class="key-concept">
                <strong>Opening Tag:</strong> <code>&lt;?php</code> marks the start of PHP code<br>
                <strong>Closing Tag:</strong> <code>?&gt;</code> marks the end of PHP code<br>
                <strong>File Extension:</strong> Files must be saved as <code>.php</code> (not .html)<br>
                <strong>Statements:</strong> Each statement must end with a semicolon <code>;</code><br>
                <strong>Comments:</strong> Use <code>//</code> for single-line or <code>/* */</code> for multi-line comments
            </div>

            <h3>1.4 Output Statements: echo vs print</h3>
            <table>
                <tr>
                    <th>Feature</th>
                    <th>echo</th>
                    <th>print</th>
                </tr>
                <tr>
                    <td><strong>Parameters</strong></td>
                    <td>Accepts multiple parameters</td>
                    <td>Accepts only one parameter</td>
                </tr>
                <tr>
                    <td><strong>Return Value</strong></td>
                    <td>No return value</td>
                    <td>Returns 1</td>
                </tr>
                <tr>
                    <td><strong>Speed</strong></td>
                    <td>Faster</td>
                    <td>Slightly slower</td>
                </tr>
                <tr>
                    <td><strong>Usage</strong></td>
                    <td>More commonly used</td>
                    <td>Less frequently used</td>
                </tr>
            </table>

            <p><strong>Recommendation:</strong> Use <code>echo</code> in most cases for optimal performance and flexibility.</p>

            <h3>1.5 How PHP Works: Request-Response Cycle</h3>
            <p>When a user requests a PHP file, the following process occurs:</p>
            <div class="procedure">
                <ol>
                    <li><strong>Browser Request:</strong> User enters URL or clicks link (e.g., http://localhost/index.php)</li>
                    <li><strong>Server Receives:</strong> Web server (Apache) receives the HTTP request</li>
                    <li><strong>PHP Processing:</strong> Server identifies .php file and passes it to PHP processor</li>
                    <li><strong>Code Execution:</strong> PHP processes code, may query database, performs calculations</li>
                    <li><strong>HTML Generation:</strong> PHP generates HTML output</li>
                    <li><strong>Response Sent:</strong> Server sends HTML response back to browser</li>
                    <li><strong>Browser Display:</strong> Browser renders HTML and displays webpage to user</li>
                </ol>
            </div>

            <div class="key-concept">
                <strong>Critical Concept:</strong> The user NEVER sees PHP code—only the HTML output. This is the fundamental difference between server-side (PHP) and client-side (HTML/CSS/JavaScript) processing.
            </div>

            <h3>1.6 Embedding PHP in HTML</h3>
            <p>PHP can be embedded directly within HTML files. The PHP code executes on the server, and only the HTML output is sent to the browser.</p>

            <div class="starter-code">
&lt;!DOCTYPE html&gt;
&lt;html&gt;
&lt;head&gt;
    &lt;title&gt;PHP Example&lt;/title&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;h1&gt;Welcome&lt;/h1&gt;
    
    &lt;?php
        // Method 1: Simple echo
        echo "Hello World!";
        
        // Method 2: With HTML tags
        echo "&lt;p&gt;Today is: " . date("Y-m-d") . "&lt;/p&gt;";
        
        // Method 3: Shorthand (if enabled)
    ?&gt;
    
    &lt;p&gt;Current time: &lt;?= date("H:i:s") ?&gt;&lt;/p&gt;
&lt;/body&gt;
&lt;/html&gt;
            </div>

            <h3>1.7 Comments in PHP</h3>
            <p>Comments are non-executable text that explain code. They are ignored by the PHP processor:</p>
            <div class="key-concept">
                <strong>Single-line:</strong> <code>// comment</code> or <code># comment</code><br>
                <strong>Multi-line:</strong> <code>/* comment */</code><br>
                <strong>Documentation:</strong> <code>/** documentation */</code> for functions and classes
            </div>

            <h3>1.8 Best Practices and Common Errors</h3>
            <table>
                <tr>
                    <th>Best Practice</th>
                    <th>Common Error</th>
                </tr>
                <tr>
                    <td>Always use <code>&lt;?php</code> opening tag</td>
                    <td>Using short tag <code>&lt;?</code> (may not be enabled)</td>
                </tr>
                <tr>
                    <td>End statements with semicolon <code>;</code></td>
                    <td>Missing semicolon causes parse error</td>
                </tr>
                <tr>
                    <td>Save files with <code>.php</code> extension</td>
                    <td>Saving as <code>.html</code> prevents PHP execution</td>
                </tr>
                <tr>
                    <td>Write meaningful comments for complex code</td>
                    <td>No documentation makes code difficult to maintain</td>
                </tr>
                <tr>
                    <td>Use proper quote matching</td>
                    <td>Mismatched quotes cause syntax errors</td>
                </tr>
            </table>

        </div>

        <!-- PAGE BREAK -->
        <div class="page-break"></div>

        <!-- SECTION 2: PRACTICAL TASK (MANDATORY) -->
        <div class="section">
            <div class="section-header">SECTION 2: PRACTICAL TASK (MANDATORY)</div>

            <h3>2.1 Task Overview and Scenario</h3>
            <p><strong>Scenario:</strong> You are developing a welcome page for the INS3064 course website. The page must display personalized greeting information and demonstrate proper PHP syntax integration with HTML. Your task is to create a professional welcome page that combines HTML structure with dynamic PHP content.</p>

            <div class="learning-outcome">
                <strong>Learning Outcome:</strong> Upon completion, you will be able to create and deploy a PHP file that displays dynamic content, properly embeds PHP code in HTML, and follows professional coding standards.
            </div>

            <h3>2.2 Starter Material</h3>
            <p>Use the following starter HTML/PHP structure as your foundation:</p>

            <div class="starter-code">
&lt;!DOCTYPE html&gt;
&lt;html lang="en"&gt;
&lt;head&gt;
    &lt;meta charset="UTF-8"&gt;
    &lt;meta name="viewport" content="width=device-width, initial-scale=1.0"&gt;
    &lt;title&gt;INS3064 Welcome Page&lt;/title&gt;
    &lt;style&gt;
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 600px;
            text-align: center;
        }
        h1 { color: #667eea; margin-bottom: 20px; }
        .info { background: #f0f0f0; padding: 20px; border-radius: 5px; margin: 20px 0; }
        .info p { margin: 10px 0; text-align: left; }
        .label { font-weight: bold; color: #667eea; }
    &lt;/style&gt;
&lt;/head&gt;
&lt;body&gt;
    &lt;div class="container"&gt;
        &lt;h1&gt;Welcome to INS3064&lt;/h1&gt;
        
        &lt;?php
            // TODO: Add your PHP code here
            
        ?&gt;
    &lt;/div&gt;
&lt;/body&gt;
&lt;/html&gt;
            </div>

            <h3>2.3 Step-by-Step Task Instructions</h3>

            <h4>Step 1: Create the PHP File</h4>
            <div class="procedure">
                <ol>
                    <li>Open VS Code</li>
                    <li>Create a new file</li>
                    <li>Save it as <code>welcome.php</code> in folder: <code>C:\xampp\htdocs\ins3064\session_01\</code></li>
                    <li>Copy the starter material above into your file</li>
                </ol>
            </div>

            <h4>Step 2: Add PHP Code to Display Student Information</h4>
            <p>Inside the TODO section, add PHP code to display:</p>
            <div class="procedure">
                <ol>
                    <li>Your full name (assign to PHP variable: $name)</li>
                    <li>Your student ID (assign to PHP variable: $studentId)</li>
                    <li>Your class/section (assign to PHP variable: $class)</li>
                    <li>Email address (assign to PHP variable: $email)</li>
                    <li>Current date in format "Monday, January 16, 2026" (use date() function)</li>
                    <li>Current time in format "HH:MM:SS" (use date() function)</li>
                </ol>
            </div>

            <p><strong>Example Output Format (in the .info div):</strong></p>
            <div class="starter-code">
&lt;div class="info"&gt;
    &lt;p&gt;&lt;span class="label"&gt;Name:&lt;/span&gt; [Display your name using PHP echo]&lt;/p&gt;
    &lt;p&gt;&lt;span class="label"&gt;Student ID:&lt;/span&gt; [Display your ID using PHP echo]&lt;/p&gt;
    &lt;p&gt;&lt;span class="label"&gt;Class:&lt;/span&gt; [Display your class using PHP echo]&lt;/p&gt;
    &lt;p&gt;&lt;span class="label"&gt;Email:&lt;/span&gt; [Display your email using PHP echo]&lt;/p&gt;
    &lt;p&gt;&lt;span class="label"&gt;Date:&lt;/span&gt; [Display current date using PHP date() function]&lt;/p&gt;
    &lt;p&gt;&lt;span class="label"&gt;Time:&lt;/span&gt; [Display current time using PHP date() function]&lt;/p&gt;
&lt;/div&gt;
            </div>

            <h4>Step 3: Test Your File</h4>
            <div class="procedure">
                <ol>
                    <li>Save your welcome.php file</li>
                    <li>Open web browser (Chrome, Firefox, Edge)</li>
                    <li>Navigate to: <code>http://localhost/ins3064/session_01/welcome.php</code></li>
                    <li>Verify all information displays correctly</li>
                    <li>Verify no PHP errors appear</li>
                    <li>Check that current date and time are displayed accurately</li>
                </ol>
            </div>

            <h4>Step 4: Verify Code Requirements</h4>
            <p>Your PHP code MUST include:</p>
            <div class="procedure">
                <ol>
                    <li><span class="checkbox"></span> Opening tag: <code>&lt;?php</code></li>
                    <li><span class="checkbox"></span> Variable assignments for name, studentId, class, email</li>
                    <li><span class="checkbox"></span> At least 4 echo statements</li>
                    <li><span class="checkbox"></span> At least one comment line (using // or /* */)</li>
                    <li><span class="checkbox"></span> date() function call for current date</li>
                    <li><span class="checkbox"></span> date() function call for current time</li>
                    <li><span class="checkbox"></span> Closing tag: <code>?&gt;</code></li>
                    <li><span class="checkbox"></span> All statements ending with semicolon</li>
                    <li><span class="checkbox"></span> File saved with .php extension</li>
                    <li><span class="checkbox"></span> Professional formatting and indentation</li>
                </ol>
            </div>

            <h3>2.4 Expected Output</h3>
            <p>When you visit <code>http://localhost/ins3064/session_01/welcome.php</code> in your browser, you should see:</p>
            <ul>
                <li>A centered white card on a purple gradient background</li>
                <li>Title "Welcome to INS3064" at the top</li>
                <li>Your personal information neatly organized in a gray box</li>
                <li>All text properly formatted and readable</li>
                <li>No error messages or PHP code visible to the user</li>
                <li>Current date and time accurately displayed</li>
            </ul>

        </div>

        <!-- PAGE BREAK -->
        <div class="page-break"></div>

        <!-- SECTION 3: PROOF OF WORK -->
        <div class="section">
            <div class="section-header">SECTION 3: PROOF OF WORK</div>

            <h3>3.1 Required Submission Evidence</h3>
            <p>To verify successful completion of this practical task, you must submit the following evidence:</p>

            <h4>Evidence Item 1: Screenshot of Running PHP File</h4>
            <div class="evidence-box">
                <strong>What to Submit:</strong><br>
                A screenshot showing:<br>
                • Browser address bar displaying <code>http://localhost/ins3064/session_01/welcome.php</code><br>
                • Your welcome page displaying in the browser<br>
                • All personal information visible and correctly displayed<br>
                • Current date and time showing accurately<br>
                • No error messages or warnings<br>
                <br>
                <strong>File Name:</strong> <code>01_Welcome_Page_Screenshot.png</code>
            </div>

            <h4>Evidence Item 2: PHP Source Code File</h4>
            <div class="evidence-box">
                <strong>What to Submit:</strong><br>
                The actual <code>welcome.php</code> file containing:<br>
                • Complete HTML structure with proper DOCTYPE<br>
                • CSS styling for visual presentation<br>
                • PHP code section with variable assignments<br>
                • echo statements for output<br>
                • date() function calls<br>
                • Comments explaining the code<br>
                • Proper closing tags<br>
                <br>
                <strong>File Location:</strong> <code>C:\xampp\htdocs\ins3064\session_01\welcome.php</code><br>
                <strong>File Name for Submission:</strong> <code>02_welcome.php</code>
            </div>

            <h4>Evidence Item 3: Code Review Checklist</h4>
            <p>Complete this checklist to verify your code meets all requirements:</p>
            <table class="rubric-table">
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>File has .php extension and correct location</td>
                    <td class="score-cell">___/2</td>
                </tr>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>PHP opening tag (&lt;?php) present</td>
                    <td class="score-cell">___/2</td>
                </tr>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>PHP closing tag (?&gt;) present</td>
                    <td class="score-cell">___/2</td>
                </tr>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>Variable assignments for name, studentId, class, email</td>
                    <td class="score-cell">___/3</td>
                </tr>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>At least 4 echo statements displaying variables</td>
                    <td class="score-cell">___/3</td>
                </tr>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>date() function for current date display</td>
                    <td class="score-cell">___/2</td>
                </tr>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>date() function for current time display</td>
                    <td class="score-cell">___/2</td>
                </tr>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>At least one comment line (// or /* */)</td>
                    <td class="score-cell">___/2</td>
                </tr>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>All statements properly end with semicolon</td>
                    <td class="score-cell">___/3</td>
                </tr>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>Code is readable with proper indentation</td>
                    <td class="score-cell">___/2</td>
                </tr>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>No PHP errors when file runs in browser</td>
                    <td class="score-cell">___/3</td>
                </tr>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>Output displays professional appearance</td>
                    <td class="score-cell">___/3</td>
                </tr>
                <tr style="background: #e8f4f8; font-weight: bold;">
                    <td></td>
                    <td>TOTAL SCORE</td>
                    <td class="score-cell">___/30</td>
                </tr>
            </table>

            <h3>3.2 Submission Package</h3>
            <p>Prepare a folder named <code>Active_Learning_Session_00_01_[YourName]_[StudentID]</code> containing:</p>
            <div class="procedure">
                <ol>
                    <li><code>01_Welcome_Page_Screenshot.png</code> - Screenshot of running PHP</li>
                    <li><code>02_welcome.php</code> - Your PHP source code file</li>
                    <li><code>03_Code_Review_Checklist.txt</code> - Completed checklist with scores</li>
                </ol>
            </div>

            <p><strong>Submission Method:</strong> Compress folder into ZIP file and submit via LMS or instructor email.</p>

        </div>

        <!-- PAGE BREAK -->
        <div class="page-break"></div>

        <!-- SECTION 4: REFLECTIVE QUESTION -->
        <div class="section">
            <div class="section-header">SECTION 4: CRITICAL THINKING QUESTION</div>

            <h3>4.1 Reflective Analysis Question</h3>

            <p><strong>Question:</strong> You are a web developer hired to build a secure login system for an online banking website. The system must store user credentials (username and password) and verify them against a database each time a user logs in. Explain why this login functionality MUST be implemented using PHP (server-side) rather than JavaScript (client-side). Identify at least three specific security risks that would occur if login verification were performed using JavaScript on the client's browser instead of PHP on the server.</p>

            <div class="answer-space"></div>
            <div class="answer-space"></div>
            <div class="answer-space"></div>
            <div class="answer-space"></div>
            <div class="answer-space"></div>

            <h3>4.2 Critical Analysis Guidance</h3>
            <p>In your response, consider:</p>
            <div class="procedure">
                <ol>
                    <li>How would a malicious user be able to see JavaScript code in the browser's source?</li>
                    <li>What would happen if passwords were checked with JavaScript on the client-side?</li>
                    <li>How could an attacker modify JavaScript code to bypass authentication?</li>
                    <li>Why is server-side processing essential for protecting sensitive data?</li>
                    <li>What is the fundamental difference in security between client-side and server-side processing?</li>
                </ol>
            </div>

        </div>

        <!-- PAGE BREAK -->
        <div class="page-break"></div>

        <!-- SECTION 5: CONNECTION TO ASSESSMENT -->
        <div class="section">
            <div class="section-header">SECTION 5: CONNECTION TO ASSESSMENT</div>

            <h3>5.1 Learning Outcomes Alignment</h3>
            <p>This active learning worksheet addresses the following course learning outcomes:</p>

            <table>
                <tr>
                    <th>Learning Outcome</th>
                    <th>Addressed By</th>
                </tr>
                <tr>
                    <td>Understand PHP as a server-side language</td>
                    <td>Section 1.1-1.3, Task 2.1-2.4</td>
                </tr>
                <tr>
                    <td>Write basic PHP code with proper syntax</td>
                    <td>Section 1.4-1.6, Task 2.2-2.3</td>
                </tr>
                <tr>
                    <td>Embed PHP within HTML documents</td>
                    <td>Section 1.6, Task 2.1-2.3</td>
                </tr>
                <tr>
                    <td>Execute PHP files on local server</td>
                    <td>Task 2.3, Section 3.1</td>
                </tr>
                <tr>
                    <td>Apply critical thinking to security decisions</td>
                    <td>Section 4.1-4.2, Question 4.1</td>
                </tr>
            </table>

            <h3>5.2 Grading Rubric</h3>
            <p>Your work will be evaluated using the following rubric (Total: 100 points):</p>

            <table>
                <tr>
                    <th>Component</th>
                    <th>Criteria</th>
                    <th>Points</th>
                </tr>
                <tr>
                    <td><strong>Section 1: Theory</strong></td>
                    <td>Understanding of key concepts demonstrated through worksheet completion</td>
                    <td>15</td>
                </tr>
                <tr>
                    <td><strong>Section 2: Practical Task</strong></td>
                    <td>PHP file created, runs without errors, displays all required information</td>
                    <td>30</td>
                </tr>
                <tr>
                    <td><strong>Section 3: Proof of Work</strong></td>
                    <td>Code review checklist completed accurately; evidence submitted correctly</td>
                    <td>30</td>
                </tr>
                <tr>
                    <td><strong>Section 4: Critical Thinking</strong></td>
                    <td>Question answered with thoughtful analysis and specific security examples</td>
                    <td>15</td>
                </tr>
                <tr style="background: #e8f4f8; font-weight: bold;">
                    <td colspan="2">TOTAL POINTS</td>
                    <td>100</td>
                </tr>
            </table>

            <h3>5.3 Grade Scale</h3>
            <table>
                <tr>
                    <th>Points</th>
                    <th>Grade</th>
                    <th>Assessment</th>
                </tr>
                <tr>
                    <td>90-100</td>
                    <td>A</td>
                    <td>Excellent - Advanced understanding, ready for Session 02</td>
                </tr>
                <tr>
                    <td>80-89</td>
                    <td>B</td>
                    <td>Good - Solid understanding with minor gaps</td>
                </tr>
                <tr>
                    <td>70-79</td>
                    <td>C</td>
                    <td>Satisfactory - Adequate understanding, review recommended</td>
                </tr>
                <tr>
                    <td>60-69</td>
                    <td>D</td>
                    <td>Needs Improvement - Significant gaps, consult instructor</td>
                </tr>
                <tr>
                    <td>Below 60</td>
                    <td>F</td>
                    <td>Incomplete - Retake required</td>
                </tr>
            </table>

            <h3>5.4 Preparation for Session 01 Assessment</h3>
            <p>Upon completion of this worksheet, you will be prepared for the following Session 01 assessments:</p>

            <div class="procedure">
                <ol>
                    <li><strong>PHP Syntax Quiz:</strong> Identify and correct syntax errors in PHP code</li>
                    <li><strong>Code Writing Task:</strong> Write PHP programs using echo/print statements</li>
                    <li><strong>HTML+PHP Integration:</strong> Embed PHP code within HTML documents</li>
                    <li><strong>Practical Exercise:</strong> Create dynamic webpage displaying variables and functions</li>
                </ol>
            </div>

            <h3>5.5 Self-Assessment Checklist</h3>
            <p>Before submitting, verify your completion using this checklist:</p>

            <table>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>Read and understood all theory content in Section 1</td>
                </tr>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>Completed practical task in Section 2 with all requirements met</td>
                </tr>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>Collected and organized all evidence for Section 3</td>
                </tr>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>Answered critical thinking question in Section 4 with depth</td>
                </tr>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>Verified all files are in correct location and properly named</td>
                </tr>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>PHP file runs without errors when accessed via browser</td>
                </tr>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>Code review checklist scored 25/30 or higher</td>
                </tr>
                <tr>
                    <td><span class="checkbox"></span></td>
                    <td>Submission package is organized and ready</td>
                </tr>
            </table>

            <h3>5.6 Feedback and Next Steps</h3>

            <p><strong>Upon receiving feedback:</strong></p>
            <div class="procedure">
                <ol>
                    <li>Review instructor feedback carefully</li>
                    <li>Identify any gaps in understanding</li>
                    <li>Revise your PHP code if corrections are needed</li>
                    <li>Document questions for Session 01 instructor</li>
                    <li>Review weak areas before beginning Session 01</li>
                </ol>
            </div>

            <p><strong>Ready for Session 01?</strong> If you scored 80+ points on this worksheet and can answer the critical thinking question, you are well-prepared to begin Session 01: Programming PHP - Variables, Data Types, and Operators.</p>

        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p><strong>Instructor:</strong> M.Sc. Hieu Ta Chi (Tạ Chí Hiếu)</p>
            <p><strong>Department:</strong> Applied Sciences Department - International School - VNU (IS-VNU)</p>
            <p><strong>Course:</strong> INS3064 - Multimedia Design & Web Development</p>
            <p>Active Learning Worksheet - Session 00 & 01</p>
            <p>Version 1.0 | Last Updated: January 16, 2026</p>
        </div>

    </div>
</body>
</html>