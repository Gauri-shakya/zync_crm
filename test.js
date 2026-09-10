
                const crmClients = [];
                pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

                // Blank template for custom proposals
                const blankTemplate = `
                                                                                                                                        <div class="pdf-export-container">
                                                                                                                                            <div class="pdf-section" contenteditable="true">
                                                                                                                                                <p><br></p>
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                        `;

                // Professional proposal templates wi            th PDF-friendly styling
                // Professional proposal templates with PDF-friendly styling
                const proposalTemplates = {
                    social: `
                                                                                    <div class="pdf-export-container">
                                                                                        <div class="pdf-section">
                                                                                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
                                                                                                <div>
                                                                                                    <h1 id="proposalTitle" style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 10px;" contenteditable="true">Social Media Marketing Proposal</h1>
                                                                                                    <p style="color: #6b7280;" contenteditable="true">Prepared for <span id="clientName" style="font-weight: 500;">Client Name</span> at <span id="clientCompany" style="font-weight: 500;">Company Name</span></p>
                                                                                                </div>
                                                                                                <div style="text-align: right;">
                                                                                                    <p style="color: #6b7280;">Date: <span id="proposalDate" style="font-weight: 500;">${new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span></p>
                                                                                                    <p style="color: #6b7280;">Proposal ID: <span style="font-weight: 500;">#SMM-2025-001</span></p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Service Overview</h2>
                                                                                            <div style="color: #374151;" contenteditable="true">
                                                                                                <p>This proposal outlines our comprehensive social media marketing services designed to increase your brand visibility, engage your target audience, and drive measurable results for your business.</p>
                                                                                                <p style="margin-top: 15px;">Our approach combines strategic planning, creative content development, and data-driven optimization to ensure your social media presence aligns with your business objectives.</p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Scope of Work</h2>
                                                                                            <ul style="list-style-type: disc; padding-left: 20px; color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <li>Social media strategy development</li>
                                                                                                <li>Content calendar creation and management</li>
                                                                                                <li>Platform setup and optimization (Facebook, Instagram, LinkedIn, Twitter)</li>
                                                                                                <li>Monthly content creation (30 posts per platform)</li>
                                                                                                <li>Community management and engagement</li>
                                                                                                <li>Performance tracking and monthly reporting</li>
                                                                                            </ul>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Deliverables</h2>
                                                                                            <ul style="list-style-type: disc; padding-left: 20px; color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <li>Comprehensive social media strategy document</li>
                                                                                                <li>3-month content calendar</li>
                                                                                                <li>Branded graphics and video content</li>
                                                                                                <li>Monthly performance reports with insights</li>
                                                                                                <li>Competitor analysis and hashtag research</li>
                                                                                            </ul>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Timeline</h2>
                                                                                            <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <p><strong>Week 1-2:</strong> Strategy development and platform setup</p>
                                                                                                <p><strong>Week 3-4:</strong> Content creation and calendar implementation</p>
                                                                                                <p><strong>Month 2-3:</strong> Ongoing management, optimization, and reporting</p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Investment</h2>
                                                                                            <table class="pdf-table">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Service</th>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Description</th>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Price</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">Monthly Management</td>
                                                                                                        <td style="padding: 10px; font-size: 14px; color: #6b7280;" contenteditable="true">Full social media handling</td>
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">$2,499 / month</td>
                                                                                                    </tr>
                                                                                                    <tr style="background-color: #f9fafb;">
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">Total (3 months)</td>
                                                                                                        <td style="padding: 10px; font-size: 14px; color: #6b7280;" contenteditable="true">Minimum commitment</td>
                                                                                                        <td style="padding: 10px; font-weight: bold; font-size: 18px;" contenteditable="true">$7,497</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Terms & Conditions</h2>
                                                                                            <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <p>Payment: 50% upfront, 50% after first month.</p>
                                                                                                <p style="margin-top: 10px;">Valid for 30 days. Minimum 3-month engagement.</p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Contact Us</h2>
                                                                                            <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <p><strong>Your Digital Agency</strong> | hello@agency.com | +91 98765 43210</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>`,

                    website: `
                                                                                    <div class="pdf-export-container">
                                                                                        <div class="pdf-section">
                                                                                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
                                                                                                <div>
                                                                                                    <h1 id="proposalTitle" style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 10px;" contenteditable="true">Website Development Proposal</h1>
                                                                                                    <p style="color: #6b7280;" contenteditable="true">Prepared for <span id="clientName" style="font-weight: 500;">Client Name</span> at <span id="clientCompany" style="font-weight: 500;">Company Name</span></p>
                                                                                                </div>
                                                                                                <div style="text-align: right;">
                                                                                                    <p style="color: #6b7280;">Date: <span id="proposalDate" style="font-weight: 500;">${new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span></p>
                                                                                                    <p style="color: #6b7280;">Proposal ID: <span style="font-weight: 500;">#WEB-2025-001</span></p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Project Overview</h2>
                                                                                            <div style="color: #374151;" contenteditable="true">
                                                                                                <p>We propose a modern, responsive website that reflects your brand identity and converts visitors into customers. Our team specializes in creating high-performance websites that are secure, scalable, and easy to manage.</p>
                                                                                                <p style="margin-top: 15px;">This project will focus on user experience (UX), mobile responsiveness, and search engine visibility to ensure your digital presence drives business growth.</p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Scope of Work</h2>
                                                                                            <ul style="list-style-type: disc; padding-left: 20px; color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <li>Custom UI/UX Design & Prototyping</li>
                                                                                                <li>Responsive Front-end Development (HTML5, CSS3, JS)</li>
                                                                                                <li>Content Management System (CMS) Integration</li>
                                                                                                <li>E-commerce Functionality (if required)</li>
                                                                                                <li>Basic SEO Setup & Performance Optimization</li>
                                                                                                <li>Security Configuration (SSL, Firewall)</li>
                                                                                                <li>Testing & Launch</li>
                                                                                            </ul>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Deliverables</h2>
                                                                                            <ul style="list-style-type: disc; padding-left: 20px; color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <li>Fully functional, mobile-responsive website</li>
                                                                                                <li>Source code and database access</li>
                                                                                                <li>User training for CMS management</li>
                                                                                                <li>1 month of post-launch support</li>
                                                                                            </ul>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Timeline</h2>
                                                                                            <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <p><strong>Week 1-2:</strong> Discovery & Design Phase</p>
                                                                                                <p><strong>Week 3-5:</strong> Development & Integration</p>
                                                                                                <p><strong>Week 6:</strong> Testing, Content Entry & Launch</p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Investment</h2>
                                                                                            <table class="pdf-table">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Service</th>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Description</th>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Price</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">Website Design & Dev</td>
                                                                                                        <td style="padding: 10px; font-size: 14px; color: #6b7280;" contenteditable="true">Complete site build</td>
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">Rs3,500</td>
                                                                                                    </tr>
                                                                                                    <tr style="background-color: #f9fafb;">
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">Total</td>
                                                                                                        <td style="padding: 10px; font-size: 14px; color: #6b7280;" contenteditable="true">One-time cost</td>
                                                                                                        <td style="padding: 10px; font-weight: bold; font-size: 18px;" contenteditable="true">Rs3,500</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Terms & Conditions</h2>
                                                                                            <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <p>Payment: 50% deposit, 50% upon completion.</p>
                                                                                                <p style="margin-top: 10px;">Additional features billed at hourly rate.</p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Contact Us</h2>
                                                                                            <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <p><strong>Your Digital Agency</strong> | hello@agency.com | +91 98765 43210</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>`,

                    ads: `
                                                                                    <div class="pdf-export-container">
                                                                                        <div class="pdf-section">
                                                                                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
                                                                                                <div>
                                                                                                    <h1 id="proposalTitle" style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 10px;" contenteditable="true">Google Ads Proposal</h1>
                                                                                                    <p style="color: #6b7280;" contenteditable="true">Prepared for <span id="clientName" style="font-weight: 500;">Client Name</span> at <span id="clientCompany" style="font-weight: 500;">Company Name</span></p>
                                                                                                </div>
                                                                                                <div style="text-align: right;">
                                                                                                    <p style="color: #6b7280;">Date: <span id="proposalDate" style="font-weight: 500;">${new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span></p>
                                                                                                    <p style="color: #6b7280;">Proposal ID: <span style="font-weight: 500;">#PPC-2025-001</span></p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Campaign Strategy</h2>
                                                                                            <div style="color: #374151;" contenteditable="true">
                                                                                                <p>Maximize your ROI with targeted PPC campaigns designed to capture high-intent traffic. Our data-driven approach ensures your ad spend is utilized efficiently to generate quality leads and sales.</p>
                                                                                                <p style="margin-top: 15px;">We focus on crafting compelling ad copy, optimizing landing pages, and continuous bid management to outperform competitors.</p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Services Included</h2>
                                                                                            <ul style="list-style-type: disc; padding-left: 20px; color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <li>Keyword Research & Competitor Analysis</li>
                                                                                                <li>Account Setup & Campaign Structuring</li>
                                                                                                <li>Ad Copywriting & A/B Testing</li>
                                                                                                <li>Bid Management & Budget Optimization</li>
                                                                                                <li>Conversion Tracking Setup</li>
                                                                                                <li>Weekly Performance Reporting</li>
                                                                                            </ul>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Investment</h2>
                                                                                            <table class="pdf-table">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Service</th>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Description</th>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Price</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">PPC Management Fee</td>
                                                                                                        <td style="padding: 10px; font-size: 14px; color: #6b7280;" contenteditable="true">Monthly optimization & reporting</td>
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">$1,200 / month</td>
                                                                                                    </tr>
                                                                                                    <tr style="background-color: #f9fafb;">
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">Total (3 months)</td>
                                                                                                        <td style="padding: 10px; font-size: 14px; color: #6b7280;" contenteditable="true">Minimum term</td>
                                                                                                        <td style="padding: 10px; font-weight: bold; font-size: 18px;" contenteditable="true">$3,600</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                            <p style="font-size: 12px; color: #6b7280; margin-top: 10px;">*Note: Ad spend is paid directly to the ad platform (Google/Facebook) and is not included in the management fee.</p>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Contact Us</h2>
                                                                                            <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <p><strong>Your Digital Agency</strong> | hello@agency.com | +91 98765 43210</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>`,

                    seo: `
                                                                                    <div class="pdf-export-container">
                                                                                        <div class="pdf-section">
                                                                                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
                                                                                                <div>
                                                                                                    <h1 id="proposalTitle" style="font-size: 28px; font-weight: bold; color: #1f2937; margin-bottom: 10px;" contenteditable="true">SEO Proposal</h1>
                                                                                                    <p style="color: #6b7280;" contenteditable="true">Prepared for <span id="clientName" style="font-weight: 500;">Client Name</span> at <span id="clientCompany" style="font-weight: 500;">Company Name</span></p>
                                                                                                </div>
                                                                                                <div style="text-align: right;">
                                                                                                    <p style="color: #6b7280;">Date: <span id="proposalDate" style="font-weight: 500;">${new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })}</span></p>
                                                                                                    <p style="color: #6b7280;">Proposal ID: <span style="font-weight: 500;">#SEO-2025-001</span></p>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Organic Growth Strategy</h2>
                                                                                            <div style="color: #374151;" contenteditable="true">
                                                                                                <p>Improve your search engine rankings and drive organic traffic with our comprehensive SEO services. We focus on sustainable, white-hat techniques to build long-term authority for your domain.</p>
                                                                                                <p style="margin-top: 15px;">Our strategy encompasses technical optimization, high-quality content creation, and authoritative link building.</p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Scope of Services</h2>
                                                                                            <ul style="list-style-type: disc; padding-left: 20px; color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <li>Comprehensive Site Audit & Error Fixes</li>
                                                                                                <li>On-Page Optimization (Meta tags, Headings, Images)</li>
                                                                                                <li>Technical SEO (Schema, Speed, Mobile-friendliness)</li>
                                                                                                <li>Content Strategy & Keyword Mapping</li>
                                                                                                <li>Off-Page SEO & Link Building</li>
                                                                                                <li>Google My Business Optimization</li>
                                                                                                <li>Monthly Progress Reporting</li>
                                                                                            </ul>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Deliverables & Timeline</h2>
                                                                                            <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <p><strong>Month 1:</strong> Audit, Keyword Research, and Technical Fixes</p>
                                                                                                <p><strong>Month 2:</strong> On-Page Optimization and Content Creation</p>
                                                                                                <p><strong>Month 3+:</strong> Link Building, Ongoing Optimization, and Reporting</p>
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Investment</h2>
                                                                                            <table class="pdf-table">
                                                                                                <thead>
                                                                                                    <tr>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Service</th>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Description</th>
                                                                                                        <th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; text-transform: uppercase;">Price</th>
                                                                                                    </tr>
                                                                                                </thead>
                                                                                                <tbody>
                                                                                                    <tr>
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">SEO Retainer</td>
                                                                                                        <td style="padding: 10px; font-size: 14px; color: #6b7280;" contenteditable="true">Monthly optimization & link building</td>
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">$1,800 / month</td>
                                                                                                    </tr>
                                                                                                    <tr style="background-color: #f9fafb;">
                                                                                                        <td style="padding: 10px; font-weight: 500;" contenteditable="true">Total (6 months)</td>
                                                                                                        <td style="padding: 10px; font-size: 14px; color: #6b7280;" contenteditable="true">Recommended period</td>
                                                                                                        <td style="padding: 10px; font-weight: bold; font-size: 18px;" contenteditable="true">$10,800</td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                            </table>
                                                                                        </div>

                                                                                        <div class="pdf-section">
                                                                                            <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;">Contact Us</h2>
                                                                                            <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                                                                                <p><strong>Your Digital Agency</strong> | hello@agency.com | +91 98765 43210</p>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>`,
                    social_cults_premium: `
<div class="pdf-export-container" style="background-color: #0A0F24; color: #e2e8f0; font-family: 'Inter', sans-serif;">
   <!-- Page 1: Cover Page -->
   <div class="pdf-section" style="padding: 60px 40px; min-height: 1000px; display: flex; flex-direction: column; justify-content: center; position: relative; background: linear-gradient(135deg, #0A0F24 0%, #171941 100%); page-break-after: always;">
       <div style="background: rgba(99, 102, 241, 0.2); padding: 5px 15px; border-radius: 20px; display: inline-block; margin-bottom: 30px; font-size: 12px; font-weight: 600; color: #a5b4fc;">⚡ VIRGO DIGITAL WORLD PRESENTATION</div>
       <h1 contenteditable="true" style="font-size: 48px; font-weight: bold; color: #ffffff; line-height: 1.2; margin-bottom: 20px;">Social Media Marketing &<br><span style="color: #818cf8;">Leads Generation Proposal</span></h1>
       <p contenteditable="true" style="font-size: 18px; color: #94a3b8; max-width: 600px; line-height: 1.6; margin-bottom: 100px;">Comprehensive digital strategy, performance campaigns, and audience engagement blueprint tailored for accelerated business growth.</p>
       
       <div style="display: flex; justify-content: space-between; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 30px; margin-top: auto;">
           <div>
               <div style="font-size: 12px; color: #64748b; margin-bottom: 5px; font-weight: 600; text-transform: uppercase;">Prepared For</div>
               <div contenteditable="true" style="font-size: 18px; color: #ffffff; font-weight: 500;">Womn Foundation</div>
           </div>
           <div>
               <div style="font-size: 12px; color: #64748b; margin-bottom: 5px; font-weight: 600; text-transform: uppercase;">Agency</div>
               <div contenteditable="true" style="font-size: 16px; color: #ffffff; font-weight: 500;">SOCIAL CULTS <span style="color: #818cf8;">by Virgo Digital World</span></div>
           </div>
           <div style="text-align: right;">
               <div style="font-size: 12px; color: #64748b; margin-bottom: 5px; font-weight: 600; text-transform: uppercase;">Classification</div>
               <div contenteditable="true" style="font-size: 16px; color: #10b981; font-weight: 500;">Strictly Confidential</div>
           </div>
       </div>
   </div>

   <!-- Page 2: Objectives Page -->
   <div class="pdf-section" style="padding: 60px 40px; min-height: 1000px; background: #0A0F24; page-break-after: always;">
       <h2 contenteditable="true" style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 50px; text-transform: uppercase; letter-spacing: 1px;">Core Strategic Objectives</h2>
       
       <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 30px;">
               <div style="width: 40px; height: 40px; background: rgba(99, 102, 241, 0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; color: #818cf8;">💎</div>
               <h3 contenteditable="true" style="color: #ffffff; font-size: 18px; font-weight: 600; margin-bottom: 15px; text-transform: uppercase;">Brand Building</h3>
               <p contenteditable="true" style="color: #94a3b8; font-size: 14px; line-height: 1.6;">Establish a commanding online authority and premium visual presence across key digital touchpoints to elevate brand recall and trust.</p>
           </div>
           
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 30px;">
               <div style="width: 40px; height: 40px; background: rgba(168, 85, 247, 0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; color: #c084fc;">💬</div>
               <h3 contenteditable="true" style="color: #ffffff; font-size: 18px; font-weight: 600; margin-bottom: 15px; text-transform: uppercase;">Active Engagement</h3>
               <p contenteditable="true" style="color: #94a3b8; font-size: 14px; line-height: 1.6;">Cultivate an active, loyal community through interactive content, rapid response management, and value-driven messaging.</p>
           </div>
           
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 30px;">
               <div style="width: 40px; height: 40px; background: rgba(236, 72, 153, 0.2); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; color: #f472b6;">📈</div>
               <h3 contenteditable="true" style="color: #ffffff; font-size: 18px; font-weight: 600; margin-bottom: 15px; text-transform: uppercase;">Lead Generation</h3>
               <p contenteditable="true" style="color: #94a3b8; font-size: 14px; line-height: 1.6;">Deploy high-converting B2B and B2C performance ad funnels designed to deliver qualified, high-intent sales leads consistently.</p>
           </div>
       </div>
   </div>

   <!-- Page 3: Agency Profile Page -->
   <div class="pdf-section" style="padding: 60px 40px; min-height: 1000px; background: #0A0F24; page-break-after: always;">
       <h2 contenteditable="true" style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 50px; text-transform: uppercase; letter-spacing: 1px;">Agency Profile & Track Record</h2>
       
       <div style="background: rgba(99, 102, 241, 0.2); padding: 5px 15px; border-radius: 20px; display: inline-block; margin-bottom: 30px; font-size: 12px; font-weight: 600; color: #a5b4fc;">⭐ ESTABLISHED 2016</div>
       
       <h3 contenteditable="true" style="color: #ffffff; font-size: 28px; font-weight: 700; margin-bottom: 20px; text-transform: uppercase;">Fluency Across a Variety of<br>Media & Platforms</h3>
       <p contenteditable="true" style="color: #94a3b8; font-size: 16px; max-width: 600px; line-height: 1.6; margin-bottom: 50px;">Social Cults (by Virgo Digital World) brings over a decade of domain expertise in digital transformation, high-impact branding, and metric-driven lead acquisition.</p>
       
       <div style="display: flex; gap: 20px; margin-bottom: 50px;">
           <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); padding: 10px 20px; border-radius: 8px; color: #cbd5e1; font-weight: 500;">✓ Omni-Channel Strategy</div>
           <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); padding: 10px 20px; border-radius: 8px; color: #cbd5e1; font-weight: 500;">✓ Full Funnel Optimization</div>
       </div>

       <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 40px; text-align: center;">
               <div contenteditable="true" style="font-size: 64px; font-weight: bold; color: #ffffff; margin-bottom: 10px;">10+</div>
               <div contenteditable="true" style="color: #94a3b8; font-size: 16px;">Years of Industry Leadership</div>
           </div>
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 40px; text-align: center;">
               <div contenteditable="true" style="font-size: 64px; font-weight: bold; color: #ffffff; margin-bottom: 10px;">1500+</div>
               <div contenteditable="true" style="color: #94a3b8; font-size: 16px;">Creative & Performance Clients</div>
           </div>
       </div>
   </div>

   <!-- Page 4: Global Portfolio Page -->
   <div class="pdf-section" style="padding: 60px 40px; min-height: 1000px; background: linear-gradient(135deg, #0A0F24 0%, #171941 100%); page-break-after: always;">
       <h2 contenteditable="true" style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px;">Global Brands Portfolio</h2>
       <p contenteditable="true" style="color: #94a3b8; font-size: 16px; margin-bottom: 50px;">Trusted by world-renowned multinational brands and industry titans across real estate, QSR, technology, and luxury services.</p>
       
       <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">SOBHA</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Signarama</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Papa Johns</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Caterpillar</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Veritas</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Invent</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Damac</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Mobidia</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Domino's</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Intelsat</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Emaar</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Intacct</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">RE/MAX</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">KIA</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Dell</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Urban Yog</div>
       </div>
   </div>

   <!-- Page 5: Indian Portfolio Page -->
   <div class="pdf-section" style="padding: 60px 40px; min-height: 1000px; background: linear-gradient(135deg, #0A0F24 0%, #171941 100%); page-break-after: always;">
       <h2 contenteditable="true" style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px;">Indian Enterprise Client Portfolio</h2>
       <p contenteditable="true" style="color: #94a3b8; font-size: 16px; margin-bottom: 50px;">Proven credentials in engineering market leadership for premier Indian conglomerates, automotive leaders, and real estate giants.</p>
       
       <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 15px;">
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">ATS</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Sleepwell</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Mahindra</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Prestige Group</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">M3M</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Tata Motors</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Godrej</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Spaces</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Chicago Pizza</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Bhutani</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Hyundai</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Skoda</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Warehouse Cafe</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Centennial School</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">Bachpan</div>
           <div style="background: white; height: 60px; border-radius: 30px; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-weight: bold; font-size: 14px;">ITS</div>
       </div>
   </div>

   <!-- Page 6: Target Audience Page -->
   <div class="pdf-section" style="padding: 60px 40px; min-height: 1000px; background: #0A0F24; page-break-after: always;">
       <h2 contenteditable="true" style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 50px; text-transform: uppercase; letter-spacing: 1px;">Target Audience Segmentation</h2>
       
       <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 40px 20px; text-align: center;">
               <div style="width: 50px; height: 50px; background: rgba(99, 102, 241, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: #818cf8; font-size: 24px;">👥</div>
               <h3 contenteditable="true" style="color: #ffffff; font-size: 16px; font-weight: 600; margin-bottom: 20px; text-transform: uppercase;">Age Bracket</h3>
               <div contenteditable="true" style="color: #818cf8; font-size: 28px; font-weight: bold; margin-bottom: 20px;">25 to 60+ Years</div>
               <p contenteditable="true" style="color: #94a3b8; font-size: 14px; line-height: 1.6;">Capturing mature decision makers, working professionals, & high-net-worth buyers.</p>
           </div>
           
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 40px 20px; text-align: center;">
               <div style="width: 50px; height: 50px; background: rgba(236, 72, 153, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: #f472b6; font-size: 24px;">⚧</div>
               <h3 contenteditable="true" style="color: #ffffff; font-size: 16px; font-weight: 600; margin-bottom: 20px; text-transform: uppercase;">Gender Focus</h3>
               <div contenteditable="true" style="color: #f472b6; font-size: 28px; font-weight: bold; margin-bottom: 20px;">Male & Female</div>
               <p contenteditable="true" style="color: #94a3b8; font-size: 14px; line-height: 1.6;">Balanced creative messaging targeted across demographic spectrums.</p>
           </div>
           
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 40px 20px; text-align: center;">
               <div style="width: 50px; height: 50px; background: rgba(16, 185, 129, 0.2); border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; color: #34d399; font-size: 24px;">📍</div>
               <h3 contenteditable="true" style="color: #ffffff; font-size: 16px; font-weight: 600; margin-bottom: 20px; text-transform: uppercase;">Geographic Scope</h3>
               <div contenteditable="true" style="color: #34d399; font-size: 28px; font-weight: bold; margin-bottom: 20px;">Preferred Locations</div>
               <p contenteditable="true" style="color: #94a3b8; font-size: 14px; line-height: 1.6;">Hyper-targeted geo-fencing across high-value micro-markets and key regions.</p>
           </div>
       </div>
   </div>

   <!-- Page 7: Strategic Pillars Page -->
   <div class="pdf-section" style="padding: 60px 40px; min-height: 1000px; background: linear-gradient(135deg, #0A0F24 0%, #171941 100%); page-break-after: always;">
       <h2 contenteditable="true" style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 50px; text-transform: uppercase; letter-spacing: 1px;">Our Strategic Way Ahead</h2>
       
       <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px;">
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 30px;">
               <div style="color: #818cf8; font-size: 12px; margin-bottom: 15px; text-transform: uppercase;">PILLAR 01</div>
               <h3 contenteditable="true" style="color: #ffffff; font-size: 18px; font-weight: 600; margin-bottom: 15px; text-transform: uppercase;">Brand & Service Promotion</h3>
               <p contenteditable="true" style="color: #94a3b8; font-size: 13px; line-height: 1.6;">Promoting USPs, core features, and distinct value propositions of offered services.</p>
           </div>
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 30px;">
               <div style="color: #818cf8; font-size: 12px; margin-bottom: 15px; text-transform: uppercase;">PILLAR 02</div>
               <h3 contenteditable="true" style="color: #ffffff; font-size: 18px; font-weight: 600; margin-bottom: 15px; text-transform: uppercase;">Content Strategizing</h3>
               <p contenteditable="true" style="color: #94a3b8; font-size: 13px; line-height: 1.6;">Next-gen content architecture focusing on highly engaging visuals and feature highlights.</p>
           </div>
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 30px;">
               <div style="color: #ec4899; font-size: 12px; margin-bottom: 15px; text-transform: uppercase;">PILLAR 03</div>
               <h3 contenteditable="true" style="color: #ffffff; font-size: 18px; font-weight: 600; margin-bottom: 15px; text-transform: uppercase;">Reputation Management</h3>
               <p contenteditable="true" style="color: #94a3b8; font-size: 13px; line-height: 1.6;">Active monitoring of messages, comments, and sentiment across all brand channels.</p>
           </div>
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 30px;">
               <div style="color: #10b981; font-size: 12px; margin-bottom: 15px; text-transform: uppercase;">PILLAR 04</div>
               <h3 contenteditable="true" style="color: #ffffff; font-size: 18px; font-weight: 600; margin-bottom: 15px; text-transform: uppercase;">Targeted Campaigns</h3>
               <p contenteditable="true" style="color: #94a3b8; font-size: 13px; line-height: 1.6;">B2B & B2C campaigns engineered to maximize page traffic, audience reach, and lead flow.</p>
           </div>
       </div>
   </div>

   <!-- Page 8: Content Ecosystem Page -->
   <div class="pdf-section" style="padding: 60px 40px; min-height: 1000px; background: #0A0F24; page-break-after: always; position: relative; overflow: hidden;">
       <div style="width: 50%; padding-right: 40px; z-index: 2; position: relative;">
           <h2 contenteditable="true" style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 50px; text-transform: uppercase; letter-spacing: 1px;">Content Ecosystem Plan</h2>
           <h3 contenteditable="true" style="color: #818cf8; font-size: 20px; font-weight: 600; margin-bottom: 20px; text-transform: uppercase;">Omni-Channel Reach</h3>
           <p contenteditable="true" style="color: #94a3b8; font-size: 14px; line-height: 1.6; margin-bottom: 30px;">We engineer multi-format creative assets to engage target personas across every stage of the digital decision-making journey.</p>
           
           <ul style="list-style: none; padding: 0; color: #e2e8f0; line-height: 1.6;">
               <li style="margin-bottom: 20px; display: flex; align-items: flex-start;"><span style="color: #10b981; margin-right: 10px;">✓</span> <div contenteditable="true"><strong>Informative Graphics:</strong> High-impact visual posts highlighting key USPs.</div></li>
               <li style="margin-bottom: 20px; display: flex; align-items: flex-start;"><span style="color: #10b981; margin-right: 10px;">✓</span> <div contenteditable="true"><strong>Dynamic Video Reels:</strong> Short-form video content driving viral brand reach.</div></li>
               <li style="margin-bottom: 20px; display: flex; align-items: flex-start;"><span style="color: #10b981; margin-right: 10px;">✓</span> <div contenteditable="true"><strong>Articles & Discussions:</strong> Thought leadership content prompting community dialogue.</div></li>
               <li style="margin-bottom: 20px; display: flex; align-items: flex-start;"><span style="color: #10b981; margin-right: 10px;">✓</span> <div contenteditable="true"><strong>Interactive GIFs:</strong> Engaging visual motion graphics boost page interaction.</div></li>
           </ul>
       </div>
       <div style="position: absolute; right: 0; top: 0; bottom: 0; width: 45%; background: rgba(99, 102, 241, 0.1); border-left: 1px solid rgba(255,255,255,0.1); display: flex; align-items: center; justify-content: center; color: #475569;">
           <span style="font-size: 24px;">[Content Strategy Image Area]</span>
       </div>
   </div>

   <!-- Page 9: Deliverables Page -->
   <div class="pdf-section" style="padding: 60px 40px; min-height: 1000px; background: linear-gradient(135deg, #0A0F24 0%, #171941 100%); page-break-after: always;">
       <h2 contenteditable="true" style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 50px; text-transform: uppercase; letter-spacing: 1px;">Monthly Deliverables & Services Scope</h2>
       
       <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 30px;">
               <h3 contenteditable="true" style="color: #818cf8; font-size: 20px; font-weight: 600; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;"><span>📚</span> Core Deliverables</h3>
               <ul style="list-style: none; padding: 0; color: #cbd5e1; line-height: 1.6; font-size: 14px;">
                   <li style="margin-bottom: 20px; display: flex; align-items: flex-start;"><span style="color: #34d399; margin-right: 10px;">✓</span> <div contenteditable="true"><strong>15–20 Creative & Reels / Monthly (Variable):</strong> A flexible mix of high-quality graphics and engaging reels based on the content strategy and campaign requirements.</div></li>
                   <li style="margin-bottom: 20px; display: flex; align-items: flex-start;"><span style="color: #34d399; margin-right: 10px;">✓</span> <div contenteditable="true"><strong>Custom Campaign Creatives:</strong> Tailored visual variations designed for promotions, campaigns, and performance marketing.</div></li>
                   <li style="margin-bottom: 20px; display: flex; align-items: flex-start;"><span style="color: #34d399; margin-right: 10px;">✓</span> <div contenteditable="true"><strong>Dedicated Team (5–7 Specialists):</strong> Account Manager, Social Media Strategist, Graphic Designer, Media Buyer, Video Editor, and SEO Expert.</div></li>
               </ul>
           </div>
           
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; padding: 30px;">
               <ul style="list-style: none; padding: 0; color: #cbd5e1; line-height: 1.6; font-size: 14px;">
                   <li style="margin-bottom: 25px; display: flex; align-items: flex-start;"><span style="color: #34d399; margin-right: 10px;">✓</span> <div contenteditable="true"><strong>Competitor Analysis & Ad Review:</strong> In-depth monitoring of competitor strategies.</div></li>
                   <li style="margin-bottom: 25px; display: flex; align-items: flex-start;"><span style="color: #34d399; margin-right: 10px;">✓</span> <div contenteditable="true"><strong>Community Management:</strong> Social media page monitoring and prompt comment responses.</div></li>
                   <li style="margin-bottom: 25px; display: flex; align-items: flex-start;"><span style="color: #34d399; margin-right: 10px;">✓</span> <div contenteditable="true"><strong>Daily Reporting:</strong> Real-time performance tracking and lead verification reports.</div></li>
                   <li style="margin-bottom: 25px; display: flex; align-items: flex-start;"><span style="color: #34d399; margin-right: 10px;">✓</span> <div contenteditable="true"><strong>Audience Growth:</strong> Consistent increase in followers, likes, downloads, and conversions.</div></li>
               </ul>
           </div>
       </div>
   </div>

   <!-- Page 10: Pricing Page -->
   <div class="pdf-section" style="padding: 60px 40px; min-height: 1000px; background: linear-gradient(135deg, #0A0F24 0%, #171941 100%); page-break-after: always;">
       <h2 contenteditable="true" style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 50px; text-transform: uppercase; letter-spacing: 1px;">Investment & Campaign Structure</h2>
       
       <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(99, 102, 241, 0.3); border-radius: 16px; padding: 30px;">
               <div style="background: rgba(16, 185, 129, 0.2); color: #34d399; font-size: 12px; font-weight: bold; padding: 5px 12px; border-radius: 20px; display: inline-block; margin-bottom: 30px;">3-MONTH SERVICE PACKAGE</div>
               
               <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                   <h3 contenteditable="true" style="color: #ffffff; font-size: 24px; font-weight: 700; margin: 0;">Channel Package</h3>
                   <div contenteditable="true" style="background: #10b981; color: white; padding: 8px 16px; border-radius: 30px; font-weight: bold;">1 Lakh + GST</div>
               </div>
               
               <ul contenteditable="true" style="color: #e2e8f0; list-style: none; padding: 0; margin-bottom: 30px; line-height: 2;">
                   <li style="position: relative; padding-left: 20px;">• 1 Long video (more than 1 hour)</li>
                   <li style="position: relative; padding-left: 20px;">• 5-6 Reels</li>
                   <li style="position: relative; padding-left: 20px;">• 1 Article in Website and LinkedIn</li>
               </ul>

               <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                   <h3 contenteditable="true" style="color: #ffffff; font-size: 20px; font-weight: 600; margin: 0;">Social Media Management</h3>
                   <div contenteditable="true" style="background: #10b981; color: white; padding: 6px 14px; border-radius: 30px; font-weight: bold; font-size: 14px;">35,000 + GST</div>
               </div>

               <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                   <h3 contenteditable="true" style="color: #ffffff; font-size: 20px; font-weight: 600; margin: 0;">Podcast</h3>
                   <div contenteditable="true" style="background: #10b981; color: white; padding: 6px 14px; border-radius: 30px; font-weight: bold; font-size: 14px;">1 Lakh + GST</div>
               </div>
               
               <div contenteditable="true" style="font-size: 12px; color: #94a3b8; background: rgba(0,0,0,0.2); padding: 10px; border-radius: 8px;">
                   ℹ️ Note: Media Ad Budget will be borne directly by the client.
               </div>
           </div>
           
           <div style="display: flex; flex-direction: column; gap: 20px;">
               <h3 contenteditable="true" style="color: #ffffff; font-size: 20px; font-weight: 600; margin-bottom: 10px; text-transform: uppercase;">Paid Campaign Execution</h3>
               
               <div contenteditable="true" style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 20px; display: flex; gap: 15px; align-items: flex-start;">
                   <div style="color: #3b82f6; font-size: 24px;">f</div>
                   <div>
                       <div style="color: #ffffff; font-weight: 600; margin-bottom: 5px;">Facebook & Instagram Ads:</div>
                       <div style="color: #94a3b8; font-size: 14px;">Complete setup and daily optimization.</div>
                   </div>
               </div>
               
               <div contenteditable="true" style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 20px; display: flex; gap: 15px; align-items: flex-start;">
                   <div style="color: #ec4899; font-size: 24px;">◎</div>
                   <div>
                       <div style="color: #ffffff; font-weight: 600; margin-bottom: 5px;">Campaign Types:</div>
                       <div style="color: #94a3b8; font-size: 14px;">Brand Awareness, Lead Generation, Page Likes/Followers.</div>
                   </div>
               </div>

               <div contenteditable="true" style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 20px; display: flex; gap: 15px; align-items: flex-start;">
                   <div style="color: #f59e0b; font-size: 24px;">👥</div>
                   <div>
                       <div style="color: #ffffff; font-weight: 600; margin-bottom: 5px;">Influencer Marketing:</div>
                       <div style="color: #94a3b8; font-size: 14px;">Strategic tie-ups with niche content creators.</div>
                   </div>
               </div>
               
               <div contenteditable="true" style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 12px; padding: 15px; text-align: center; color: #34d399; font-weight: 600; margin-top: auto;">
                   100% Business Commitment & Service Guarantee
               </div>
           </div>
       </div>
   </div>

   <!-- Page 11: Why Partner Page -->
   <div class="pdf-section" style="padding: 60px 40px; min-height: 1000px; background: #0A0F24; page-break-after: always; text-align: center;">
       <h2 contenteditable="true" style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 60px; text-transform: uppercase; letter-spacing: 1px; text-align: left;">Why Partner With Social Cults?</h2>
       
       <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 20px; margin-bottom: 60px;">
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 40px 20px;">
               <div contenteditable="true" style="color: #ffffff; font-size: 36px; font-weight: bold; margin-bottom: 10px;">4,200 +</div>
               <div contenteditable="true" style="color: #94a3b8; font-size: 14px;">Channels Listed</div>
           </div>
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 40px 20px;">
               <div contenteditable="true" style="color: #ffffff; font-size: 36px; font-weight: bold; margin-bottom: 10px;">10 Lakh +</div>
               <div contenteditable="true" style="color: #94a3b8; font-size: 14px;">Leads Generated</div>
           </div>
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 40px 20px;">
               <div contenteditable="true" style="color: #ffffff; font-size: 36px; font-weight: bold; margin-bottom: 10px;">20 Cr* +</div>
               <div contenteditable="true" style="color: #94a3b8; font-size: 14px;">Ad Budget Managed</div>
           </div>
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 40px 20px;">
               <div contenteditable="true" style="color: #ffffff; font-size: 36px; font-weight: bold; margin-bottom: 10px;">15+ Years</div>
               <div contenteditable="true" style="color: #94a3b8; font-size: 14px;">Industry Experience Team</div>
           </div>
       </div>
       
       <div contenteditable="true" style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 20px; display: inline-block; color: #e2e8f0; font-size: 16px;">
           🚀 Maximizing ROI through Low Management Costs & High-Impact Ad Funnels
       </div>
   </div>

   <!-- Page 12: Thank You Page -->
   <div class="pdf-section" style="padding: 60px 40px; min-height: 1000px; background: linear-gradient(135deg, #0A0F24 0%, #171941 100%); page-break-after: always; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;">
       <div style="background: rgba(99, 102, 241, 0.2); color: #a5b4fc; font-size: 14px; padding: 8px 24px; border-radius: 30px; margin-bottom: 30px; display: inline-flex; align-items: center; gap: 10px;">
           <span>↗️</span> READY TO SCALED YOUR BRAND
       </div>
       
       <h1 contenteditable="true" style="font-size: 72px; font-weight: bold; color: #ffffff; margin-bottom: 30px;">Thank You</h1>
       <p contenteditable="true" style="color: #94a3b8; font-size: 18px; max-width: 600px; margin-bottom: 80px;">We look forward to driving high-performance digital growth and lead generation for your brand.</p>
       
       <div style="display: flex; justify-content: space-between; width: 100%; max-width: 800px; border-top: 1px solid rgba(255,255,255,0.1); border-bottom: 1px solid rgba(255,255,255,0.1); padding: 40px 0; text-align: left;">
           <div>
               <div style="color: #818cf8; font-size: 24px; margin-bottom: 10px;">🏢</div>
               <div contenteditable="true" style="color: #ffffff; font-weight: 600; font-size: 16px;">SOCIAL CULTS</div>
               <div contenteditable="true" style="color: #94a3b8; font-size: 14px;">By Virgo Digital World</div>
           </div>
           <div>
               <div style="color: #818cf8; font-size: 24px; margin-bottom: 10px;">📍</div>
               <div contenteditable="true" style="color: #ffffff; font-weight: 600; font-size: 16px;">CORPORATE ADDRESS</div>
               <div contenteditable="true" style="color: #94a3b8; font-size: 14px; max-width: 200px;">A 217, TOWER 3 , NX ONE, GR. NOIDA WEST</div>
           </div>
           <div>
               <div style="color: #818cf8; font-size: 24px; margin-bottom: 10px;">🌐</div>
               <div contenteditable="true" style="color: #ffffff; font-weight: 600; font-size: 16px;">WEBSITE</div>
               <div contenteditable="true" style="color: #94a3b8; font-size: 14px;">www.socialcults.com</div>
           </div>
       </div>
   </div>
    
   <!-- Page 13: Next Steps Page -->
   <div class="pdf-section" style="padding: 60px 40px; min-height: 1000px; background: #0A0F24;">
       <h2 contenteditable="true" style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 1px;">Next Steps</h2>
       <p contenteditable="true" style="color: #94a3b8; font-size: 18px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 40px;">From Strategy to Execution</p>
       
       <p contenteditable="true" style="color: #cbd5e1; font-size: 14px; text-transform: uppercase; line-height: 1.6; margin-bottom: 50px;">Once <span style="font-weight: bold; color: white; font-size: 18px;">Womn Foundation</span> accepts the proposal, Social Cults will move through a structured onboarding process designed to ensure a smooth and measurable launch.</p>
       
       <div style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr; gap: 15px; margin-bottom: 40px;">
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 25px; text-align: center;">
               <h3 contenteditable="true" style="color: #ffffff; font-size: 16px; font-weight: 500; margin-bottom: 15px; text-transform: uppercase; line-height: 1.4;">Proposal<br>Review</h3>
               <p contenteditable="true" style="color: #94a3b8; font-size: 12px; text-transform: uppercase; line-height: 1.5;">Review the proposed strategy, deliverables, roadmap and objectives together.</p>
           </div>
           
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 25px; text-align: center;">
               <h3 contenteditable="true" style="color: #ffffff; font-size: 16px; font-weight: 500; margin-bottom: 15px; text-transform: uppercase; line-height: 1.4;">Strategy<br>Discussion</h3>
               <p contenteditable="true" style="color: #94a3b8; font-size: 12px; text-transform: uppercase; line-height: 1.5;">A dedicated meeting with the <span style="color: white; font-weight: bold;">Womn Foundation</span> teams to understand.</p>
           </div>
           
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 25px; text-align: center;">
               <h3 contenteditable="true" style="color: #ffffff; font-size: 16px; font-weight: 500; margin-bottom: 15px; text-transform: uppercase; line-height: 1.4;">Commercial<br>Finalization</h3>
               <p contenteditable="true" style="color: #94a3b8; font-size: 12px; text-transform: uppercase; line-height: 1.5;">Finalize the scope, commercials, timelines, responsibilities and engagement terms.</p>
           </div>
           
           <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 25px; text-align: center;">
               <h3 contenteditable="true" style="color: #ffffff; font-size: 16px; font-weight: 500; margin-bottom: 15px; text-transform: uppercase; line-height: 1.4;">Onboarding &<br>Access</h3>
               <p contenteditable="true" style="color: #94a3b8; font-size: 12px; text-transform: uppercase; line-height: 1.5;">Collect the required access and business assets:<br>Website • Meta Business Manager • Google Ads • Analytics • Search Console • Social Profiles • CRM • Brand Assets</p>
           </div>
       </div>
       
       <div contenteditable="true" style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255,255,255,0.1); border-radius: 12px; padding: 20px; text-align: center; color: #e2e8f0; font-size: 14px;">
           Maximizing ROI through Low Management Costs & High-Impact Ad Funnels
       </div>
   </div>
</div>
`
                };



                // Default templates (cannot be deleted)
                const defaultTemplates = [
                    { id: 'premium_deck', name: "Social Cults Premium Deck", description: "Dark themed premium pitch deck matching the PDF presentation", key: "social_cults_premium", icon: "gem", color: "purple", isDefault: true },
                    { id: 1, name: "Social Media Marketing Proposal", description: "Complete social media strategy, content calendar, and performance tracking", key: "social", icon: "hashtag", color: "indigo", isDefault: true },
                    { id: 2, name: "Website Development Proposal", description: "Custom website design, development, and ongoing maintenance", key: "website", icon: "globe", color: "blue", isDefault: true },
                    { id: 3, name: "Google Ads Proposal", description: "PPC campaign setup, management, and optimization for maximum ROI", key: "ads", icon: "ad", color: "green", isDefault: true },
                    { id: 4, name: "SEO Proposal", description: "Search engine optimization strategy to improve organic rankings", key: "seo", icon: "search", color: "purple", isDefault: true }
                ];

                let customTemplates = [];
                let nextId = 5;
                const iconMap = { hashtag: "fas fa-hashtag", globe: "fas fa-globe", ad: "fas fa-ad", search: "fas fa-search", palette: "fas fa-palette", briefcase: "fas fa-briefcase", "chart-line": "fas fa-chart-line" };

                const proposalCardsGrid = document.getElementById('proposalCardsGrid');
                const fullEditorView = document.getElementById('fullEditorView');
                const proposalContent = document.getElementById('proposalContent');
                let currentTemplate = null;
                let selectedFile = null;
                let currentProposal = null;
                let savedProposals = [];

                // Inject Company ID for multi-tenancy scoping
                const companyId = 1;

                // localStorage functions
                function saveTemplates() {
                    const customOnly = customTemplates.filter(t => !t.isDefault);
                    localStorage.setItem(`proposalCustomTemplates_${companyId}`, JSON.stringify(customOnly));
                    localStorage.setItem(`proposalNextId_${companyId}`, nextId.toString());
                }

                async function loadTemplates() {
                    try {
                        const saved = localStorage.getItem(`proposalCustomTemplates_${companyId}`);
                        const savedNextId = localStorage.getItem(`proposalNextId_${companyId}`);

                        // Fetch hidden templates from backend
                        let hiddenTemplates = [];
                        try {
                            const response = await fetch('1', {
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json'
                                }
                            });
                            const data = await response.json();
                            hiddenTemplates = data.hidden_templates || [];
                        } catch (e) {
                            console.error('Error fetching hidden templates:', e);
                        }

                        let currentTemplates = [];

                        // Filter out hidden default templates (from backend)
                        const activeDefaults = defaultTemplates.filter(t => !hiddenTemplates.includes(t.key));

                        if (saved) {
                            const customOnly = JSON.parse(saved);
                            currentTemplates = [...activeDefaults, ...customOnly];
                        } else {
                            currentTemplates = [...activeDefaults];
                        }

                        customTemplates = currentTemplates;

                        if (savedNextId) {
                            nextId = parseInt(savedNextId);
                        }

                        // Render templates after loading
                        renderTemplates();
                    } catch (e) {
                        console.error('Error loading templates:', e);
                        customTemplates = [...defaultTemplates];
                        // Still render even if there was an error
                        renderTemplates();
                    }
                }

                async function deleteTemplate(templateId) {
                    const templateIndex = customTemplates.findIndex(t => t.id === templateId);
                    if (templateIndex === -1) return;
                    const template = customTemplates[templateIndex];

                    if (!confirm(`Are you sure you want to delete "${template.name}"? This will hide it from the list.`)) {
                        return;
                    }

                    if (template.isDefault) {
                        // For default templates, hide them via backend
                        try {
                            const response = await fetch('1', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ template_key: template.key })
                            });

                            if (!response.ok) {
                                throw new Error('Failed to hide template');
                            }
                        } catch (e) {
                            console.error('Error hiding template:', e);
                            alert('Failed to hide template. Please try again.');
                            return;
                        }
                        // Remove default template from local array as it is hidden on backend
                        customTemplates.splice(templateIndex, 1);
                    } else {
                        // Soft delete for custom templates: mark as deleted
                        template.deleted = true;
                    }

                    // Check if the deleted template is the currently active one
                    if (currentTemplate && currentTemplate.id === templateId) {
                        currentTemplate = null;
                        
                        // If we are in editor mode, exit to cards view
                        if (!document.getElementById('fullEditorView').classList.contains('hidden')) {
                            const backToCardsBtn = document.getElementById('backToCards');
                            if (backToCardsBtn) {
                                backToCardsBtn.click();
                            } else {
                                // Fallback manual switch
                                document.getElementById('fullEditorView').classList.add('hidden');
                                document.getElementById('formattingToolbar')?.classList.add('hidden');
                                document.getElementById('proposalCardsView').classList.remove('hidden');
                                renderSavedProposals();
                            }
                        }
                    }

                    saveTemplates();
                    renderTemplates();
                }

                async function switchTemplate(t) {
                    if (!fullEditorView.classList.contains('hidden')) {
                        // User is currently editing a proposal
                        if (confirm('Do you want to save your current proposal draft before switching templates?')) {
                            // User wants to save
                            await saveProposalToServer();
                            // Proceed to switch after saving
                        } else {
                            // User chose not to save, confirm discard
                            if (!confirm('Are you sure you want to discard unsaved changes and switch templates?')) {
                                return; // Cancel switch
                            }
                        }
                        
                        // Close editor and return to cards view
                        fullEditorView.classList.add('hidden');
                        const formattingToolbar = document.getElementById('formattingToolbar');
                        if (formattingToolbar) {
                            formattingToolbar.style.display = 'none';
                            formattingToolbar.classList.add('hidden');
                        }
                        document.getElementById('proposalCardsView').classList.remove('hidden');
                        renderSavedProposals();
                    }

                    // Switch to new template
                    currentTemplate = t;
                    showProposalCards(t);
                }

                // Blank Card HTML Constant
                const blankCardHTML = `
                            <div class="create-card proposal-card blank-card rounded-2xl p-4 flex flex-col items-center justify-center text-center group h-48 transition-all duration-500">
                                <div class="w-12 h-12 bg-white text-indigo-500 rounded-full flex items-center justify-center mb-3 group-hover:bg-indigo-600 group-hover:text-white transition-all duration-500 shadow-sm group-hover:shadow-indigo-500/30 group-hover:scale-110 border border-indigo-50">
                                    <i class="fas fa-plus text-lg"></i>
                                </div>
                                <h3 class="text-sm font-bold text-gray-800 mb-1 group-hover:text-indigo-600 transition-colors tracking-tight">Create Blank</h3>
                                <p class="text-[10px] text-gray-500 px-2 mb-3 leading-relaxed font-medium">Start from scratch or upload your own document to begin.</p>
                                <button id="openUploadModal" class="px-4 py-1.5 bg-white border border-gray-200 text-gray-700 rounded-lg text-[10px] font-bold hover:border-indigo-500 hover:text-indigo-600 transition-all shadow-sm hover:shadow-lg hover:-translate-y-1 group-hover:bg-indigo-50">
                                    Select
                                </button>
                            </div>
                `;

                // Render Outer Templates (Main List)
                function renderTemplates() {
                    const visibleTemplates = customTemplates.filter(t => !t.deleted);

                    // If left sidebar template list still existed, we would render here.
                    // But we removed it to make room for chat UI.
                    // So we skip list.innerHTML population.

                    // Ensure we have a valid template selected
                    if (!currentTemplate && visibleTemplates.length > 0) {
                        currentTemplate = visibleTemplates[0];
                        showProposalCards(currentTemplate);
                    } else if (visibleTemplates.length === 0) {
                        // Handle empty state - clear right side but keep blank card
                        currentTemplate = null;
                        document.getElementById('proposalCardsGrid').innerHTML = blankCardHTML + `
                            <div class="col-span-full md:col-span-1 xl:col-span-2 flex flex-col items-center justify-center text-center py-10 text-gray-400">
                                <i class="fa-regular fa-folder-open text-4xl mb-4 text-gray-300"></i>
                                <p>No templates available. Create one or start blank.</p>
                            </div>
                        `;
                        // Re-attach event listener for upload modal
                        const openUploadModalBtn = document.getElementById('openUploadModal');
                        if (openUploadModalBtn) openUploadModalBtn.onclick = () => openModal('uploadModal');
                    }
                }

                // Modal Animation Helpers
                function openModal(modalId) {
                    const modal = document.getElementById(modalId);
                    const content = modal.querySelector('div[id$="Content"]') || modal.firstElementChild;
                    
                    modal.classList.remove('hidden');
                    // Force reflow
                    void modal.offsetWidth;
                    
                    modal.classList.remove('opacity-0');
                    if(content) {
                        content.classList.remove('scale-95');
                        content.classList.add('scale-100');
                    }
                    document.body.style.overflow = 'hidden';
                }

                function closeModal(modalId) {
                    const modal = document.getElementById(modalId);
                    const content = modal.querySelector('div[id$="Content"]') || modal.firstElementChild;
                    
                    modal.classList.add('opacity-0');
                    if(content) {
                        content.classList.remove('scale-100');
                        content.classList.add('scale-95');
                    }
                    
                    setTimeout(() => {
                        modal.classList.add('hidden');
                        document.body.style.overflow = '';
                    }, 300);
                }

                // Template Preview Modal Functions
                let currentPreviewTemplate = null;

                function showTemplatePreview(template) {
                    currentPreviewTemplate = template;
                    const modal = document.getElementById('templatePreviewModal');
                    const previewContent = document.getElementById('previewContent');
                    const modalTitle = document.getElementById('previewModalTitle');

                    // Set modal title
                    modalTitle.textContent = `${template.name} - Preview`;

                    // Get template content
                    let templateHTML = '';
                    if (template.isDefault && proposalTemplates[template.key]) {
                        // For default templates, use the predefined template
                        templateHTML = proposalTemplates[template.key];
                    } else {
                        // For custom templates, show a placeholder or blank template
                        templateHTML = blankTemplate;
                    }

                    // Inject content with sample data
                    let previewHTML = templateHTML
                        .replace(/\$\{new Date\(\)\.toLocaleDateString[^}]+\}/g, new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }))
                        .replace(/<span id="clientName"[^>]*>.*?<\/span>/g, '<span style="font-weight: 500;">Sample Client</span>')
                        .replace(/<span id="clientCompany"[^>]*>.*?<\/span>/g, '<span style="font-weight: 500;">Sample Company</span>');

                    // Remove contenteditable attributes
                    previewHTML = previewHTML.replace(/contenteditable="true"/g, '');

                    previewContent.innerHTML = previewHTML;

                    // Show modal
                    openModal('templatePreviewModal');
                }

                function closeTemplatePreview() {
                    closeModal('templatePreviewModal');
                    currentPreviewTemplate = null;
                }

                // Event Listeners for Preview Modal
                document.getElementById('closePreviewModal').onclick = closeTemplatePreview;
                document.getElementById('closePreviewBtn').onclick = closeTemplatePreview;

                // Click outside modal to close
                const templatePreviewModal = document.getElementById('templatePreviewModal');
                if (templatePreviewModal) {
                    templatePreviewModal.onclick = (e) => {
                        if (e.target.id === 'templatePreviewModal') {
                            closeTemplatePreview();
                        }
                    };
                }

                // ESC key to close
                document.addEventListener('keydown', (e) => {
                    const modal = document.getElementById('templatePreviewModal');
                    if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                        closeTemplatePreview();
                    }
                });

                // Use template from preview
                const useTemplateBtn = document.getElementById('useTemplateFromPreview');
                if (useTemplateBtn) {
                    useTemplateBtn.onclick = () => {
                        if (currentPreviewTemplate) {
                            closeTemplatePreview();
                            currentTemplate = currentPreviewTemplate;
                            showProposalCards(currentPreviewTemplate);
                        }
                    };
                }

                // Render Inner Templates (Quick Start Cards & Create New)
                function showProposalCards(template) {
                    const grid = document.getElementById('proposalCardsGrid');
                    
                    // Reset grid to show Blank Card first
                    grid.innerHTML = blankCardHTML;

                    // Re-attach event listener for upload modal since we overwrote the HTML
                    const openUploadModalBtn = document.getElementById('openUploadModal');
                    if (openUploadModalBtn) openUploadModalBtn.onclick = () => openModal('uploadModal');

                    // Create a single card for creating a new proposal with this template
                    const card = document.createElement('div');
                    card.className = "proposal-card bg-white rounded-2xl shadow-lg overflow-hidden border-2 border-indigo-100 hover:border-indigo-500 transition-all cursor-pointer";
                    card.innerHTML = `<div class="p-4 text-center flex flex-col items-center justify-center h-full" > 
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mb-3 text-indigo-600">
                        <i class="${iconMap[template.icon] || 'fas fa-file-alt'} text-lg"></i>
                        </div>
                        <h3 class="text-sm font-bold text-gray-800 mb-1">Create ${template.name}</h3>
                        <p class="text-gray-500 mb-3 text-[10px]">${template.description || 'Start a new proposal using this template'}</p>
                        <button class="open-editor w-full bg-indigo-600 text-white py-1.5 rounded-lg text-xs font-semibold hover:bg-indigo-700 transition-colors">
                        <i class="fas fa-plus mr-1"></i> Create Proposal
                        </button>
                        </div>`;

                    card.onclick = () => {
                        // Open the custom client search modal
                        openClientSearchModal(template);
                    };

                    proposalCardsGrid.appendChild(card);

                    // Inner Templates: Example Clients for Quick Start
                    // These are the specific instances the user sees after selecting a main category
                    // Removed dummy templates as per user request
                }

                function openFullEditor(template, client) {
                    document.getElementById('proposalCardsView').classList.add('hidden');
                    fullEditorView.classList.remove('hidden');

                    // Show formatting toolbar
                    showFormattingToolbar();

                    // Display Client Info in Header
                    const headerInfo = document.getElementById('headerClientInfo');
                    if(client.name !== 'Client Name' && client.company !== 'Company Name') {
                        let infoText = `${client.company} - ${client.name}`;
                        if(client.phone) infoText += ` | 📱 ${client.phone}`;
                        headerInfo.textContent = infoText;
                        headerInfo.classList.remove('hidden');
                    } else {
                        headerInfo.classList.add('hidden');
                    }

                    // Check if we have a saved proposal for this client and template
                    const savedProposal = savedProposals.find(p =>
                        p.client.name === client.name &&
                        p.client.company === client.company &&
                        p.template.key === template.key
                    );

                    if (savedProposal) {
                        // Wrap saved content in editable blocks if not already wrapped
                        // Check if content already has editable-block wrappers
                        if (!savedProposal.content.includes('editable-block')) {
                            const wrappedContent = wrapContentInEditableBlocks(savedProposal.content);
                            proposalContent.innerHTML = wrappedContent;
                            savedProposal.content = wrappedContent; // Update saved version
                        } else {
                            proposalContent.innerHTML = savedProposal.content;
                        }
                        currentProposal = savedProposal;
                    } else {
                        // Wrap content in editable blocks before setting
                        let templateContent = template.content || proposalTemplates[template.key] || blankTemplate;
                        
                        // Force premium deck content if the name matches (in case of localstorage cache issues)
                        if (template.name === "Social Cults Premium Deck") {
                            templateContent = proposalTemplates['social_cults_premium'];
                        }

                        const wrappedContent = wrapContentInEditableBlocks(templateContent);
                        proposalContent.innerHTML = wrappedContent;
                        currentProposal = {
                            template: template,
                            client: client,
                            content: wrappedContent,
                            lastSaved: new Date()
                        };
                    }
                    document.querySelectorAll('#clientName').forEach(el => el.textContent = client.name);
                    document.querySelectorAll('#clientCompany').forEach(el => el.textContent = client.company);

                    document.getElementById('quickEditPanel').classList.remove('translate-x-full');
                    document.getElementById('editClientName').value = client.name;
                    document.getElementById('editClientCompany').value = client.company;
                }

                // File upload functionality
                const fileInput = document.getElementById('fileInput');
                const dropZone = document.getElementById('dropZone');
                const processFileBtn = document.getElementById('processFileBtn');
                const fileDisplay = document.getElementById('fileDisplay');
                const fileNameDisplay = document.getElementById('fileNameDisplay');
                const fileSizeDisplay = document.getElementById('fileSizeDisplay');

                function showFileName(file) {
                    selectedFile = file;
                    if (fileDisplay) fileDisplay.classList.remove('hidden');
                    if (fileNameDisplay) fileNameDisplay.textContent = file.name;
                    if (fileSizeDisplay) {
                        const size = (file.size / 1024 / 1024).toFixed(2) + " MB";
                        fileSizeDisplay.textContent = size;
                    }
                    if (processFileBtn) processFileBtn.classList.remove('hidden');
                }


                function clearFileSelection() {
                    selectedFile = null;
                    if (fileInput) fileInput.value = "";
                    if (fileDisplay) fileDisplay.classList.add('hidden');
                    if (processFileBtn) processFileBtn.classList.add('hidden');
                }

                if (dropZone) {
                    dropZone.addEventListener('click', () => { if (fileInput) fileInput.click(); });
                    dropZone.addEventListener('dragover', e => { e.preventDefault(); dropZone.classList.add('border-indigo-600', 'bg-indigo-50'); });
                    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-indigo-600', 'bg-indigo-50'));
                    dropZone.addEventListener('drop', e => {
                        e.preventDefault(); dropZone.classList.remove('border-indigo-600', 'bg-indigo-50');
                        if (e.dataTransfer.files[0]) {
                            if (fileInput) fileInput.files = e.dataTransfer.files;
                            showFileName(e.dataTransfer.files[0]);
                        }
                    });
                }
                
                if (fileInput) {
                    fileInput.addEventListener('change', () => {
                        if (fileInput.files[0]) showFileName(fileInput.files[0]);
                    });
                }

                if (processFileBtn) {
                    processFileBtn.onclick = () => {
                        if (selectedFile) extractAndCreateProposal(selectedFile);
                    };
                }

                // ============================================
                // FORMATTING TOOLBAR FUNCTIONS
                // ============================================

                // Show/hide formatting toolbar
                function showFormattingToolbar() {
                    document.getElementById('formattingToolbar').style.display = 'block';
                }

                function hideFormattingToolbar() {
                    document.getElementById('formattingToolbar').style.display = 'none';
                }

                // Text formatting using execCommand
                function formatText(command) {
                    document.execCommand(command, false, null);
                }

                // Format block (heading, paragraph)
                function formatBlock(tag) {
                    if (!tag) return;
                    document.execCommand('formatBlock', false, tag);

                    // Apply inline styles based on tag
                    setTimeout(() => {
                        const selection = window.getSelection();
                        if (selection.rangeCount > 0) {
                            let element = selection.anchorNode;
                            if (element.nodeType === 3) element = element.parentElement;

                            while (element && element.tagName && element.tagName.toLowerCase() !== tag) {
                                element = element.parentElement;
                                if (!element || element.id === 'proposalContent') break;
                            }

                            if (element && element.tagName && element.tagName.toLowerCase() === tag) {
                                applyInlineStyleToElement(element, tag);
                            }
                        }
                    }, 50);
                }

                // Apply inline styles to match template pattern
                function applyInlineStyleToElement(element, tag) {
                    const styles = {
                        'h1': 'font-size: 28px; font-weight: bold; color: #1f2937; margin: 20px 0 10px 0;',
                        'h2': 'font-size: 20px; font-weight: bold; color: #1f2937; margin: 18px 0 10px 0;',
                        'h3': 'font-size: 18px; font-weight: 600; color: #374151; margin: 16px 0 8px 0;',
                        'p': 'color: #374151; margin: 10px 0; line-height: 1.6;'
                    };

                    if (styles[tag]) {
                        element.setAttribute('style', styles[tag]);
                        element.setAttribute('contenteditable', 'true');
                    }
                }

                // Font size
                function formatFontSize(size) {
                    if (!size) return;
                    document.execCommand('fontSize', false, size);
                }

                // Text color
                function formatTextColor(color) {
                    document.execCommand('foreColor', false, color);
                }

                // Background color (highlight)
                function formatBackgroundColor(color) {
                    document.execCommand('backColor', false, color);
                }

                // ============================================
                // BLOCK MANAGEMENT FUNCTIONS
                // ============================================

                let blockIdCounter = 0;

                // Add Insert Menu to DOM if not present
                if (!document.getElementById('globalInsertMenu')) {
                    const menu = document.createElement('div');
                    menu.id = 'globalInsertMenu';
                    menu.className = 'insert-menu';
                    menu.innerHTML = `
                        <div class="insert-menu-item" onclick="insertNewBlock('text')">
                            <i class="fa-solid fa-paragraph"></i> Text Block
                        </div>
                        <div class="insert-menu-item" onclick="insertNewBlock('heading')">
                            <i class="fa-solid fa-heading"></i> Heading
                        </div>
                        
                        <div class="insert-menu-item" onclick="insertNewBlock('divider')">
                            <i class="fa-solid fa-minus"></i> Divider
                        </div>
                    `;
                    document.body.appendChild(menu);
                    
                    // Close menu on click outside
                    document.addEventListener('click', (e) => {
                        if (!e.target.closest('.insert-block-btn') && !e.target.closest('.insert-menu')) {
                            menu.classList.remove('show');
                        }
                    });
                }

                let activeInsertBlockId = null;

                function openInsertMenu(btn, blockId) {
                    activeInsertBlockId = blockId;
                    const menu = document.getElementById('globalInsertMenu');
                    const rect = btn.getBoundingClientRect();
                    
                    // Position menu below the button
                    menu.style.top = (rect.bottom + 5) + 'px';
                    menu.style.left = (rect.left - (180 / 2) + 14) + 'px'; // Center relative to button
                    menu.classList.add('show');
                }

                function insertNewBlock(type) {
                    const menu = document.getElementById('globalInsertMenu');
                    menu.classList.remove('show');
                    
                    if (!activeInsertBlockId) return;
                    
                    const targetBlock = document.querySelector(`[data-block-id="${activeInsertBlockId}"]`);
                    if (!targetBlock) return;
                    
                    // Create new content based on type
                    let newContent = '';
                    if (type === 'text') {
                        newContent = `
                            <div class="pdf-section">
                                <div style="color: #374151; line-height: 1.6;" contenteditable="true">
                                    <p>New text section. Click to edit.</p>
                                </div>
                            </div>
                        `;
                    } else if (type === 'heading') {
                        newContent = `
                            <div class="pdf-section">
                                <h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin-bottom: 15px;" contenteditable="true">New Heading</h2>
                                <div style="color: #374151;" contenteditable="true">
                                    <p>Section content...</p>
                                </div>
                            </div>
                        `;
                    } else if (type === 'divider') {
                        newContent = `
                            <div class="pdf-section">
                                <hr style="margin: 20px 0; border: none; border-top: 1px solid #e5e7eb;">
                            </div>
                        `;
                    }
                    
                    // Create wrapper
                    const wrapper = document.createElement('div');
                    wrapper.className = 'editable-block';
                    const newBlockId = `block_${blockIdCounter++}`;
                    wrapper.setAttribute('data-block-id', newBlockId);
                    
                    const deleteBtn = document.createElement('button');
                    deleteBtn.className = 'delete-block-btn';
                    deleteBtn.setAttribute('contenteditable', 'false');
                    deleteBtn.innerHTML = '<span>×</span> Delete';
                    deleteBtn.setAttribute('onclick', `deleteBlock('${newBlockId}')`);
                    
                    const insertWrap = document.createElement('div');
                    insertWrap.className = 'insert-block-wrap';
                    insertWrap.setAttribute('contenteditable', 'false');
                    insertWrap.innerHTML = `
                        <button class="insert-block-btn" onclick="openInsertMenu(this, '${newBlockId}')" title="Insert New Block" contenteditable="false">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    `;
                    
                    const temp = document.createElement('div');
                    temp.innerHTML = newContent;
                    const sectionContent = temp.firstElementChild;
                    
                    wrapper.appendChild(deleteBtn);
                    wrapper.appendChild(sectionContent);
                    wrapper.appendChild(insertWrap);
                    
                    // Insert after target block
                    targetBlock.parentNode.insertBefore(wrapper, targetBlock.nextSibling);
                    
                    // Update proposal content state
                    updateProposalContent();
                }

                function deleteBlock(blockId) {
                    if (confirm('Are you sure you want to delete this block? This action cannot be undone.')) {
                        const block = document.querySelector(`[data-block-id="${blockId}"]`);
                        if (block) {
                            block.remove();
                            updateProposalContent();
                        }
                    }
                }

                function updateProposalContent() {
                    const proposalContent = document.getElementById('proposalContent');
                    if (proposalContent && currentProposal) {
                        currentProposal.content = proposalContent.innerHTML;
                        currentProposal.lastSaved = new Date();
                    }
                }

                // Wrap content sections in editable blocks
                function wrapContentInEditableBlocks(html) {
                    // Wrap each pdf-section in an editable block
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;

                    const sections = tempDiv.querySelectorAll('.pdf-section');
                    sections.forEach((section) => {
                        const wrapper = document.createElement('div');
                        wrapper.className = 'editable-block';
                        const blockId = `block_${blockIdCounter++}`;
                        wrapper.setAttribute('data-block-id', blockId);

                        const deleteBtn = document.createElement('button');
                        deleteBtn.className = 'delete-block-btn';
                        deleteBtn.setAttribute('contenteditable', 'false');
                        deleteBtn.innerHTML = '<span>×</span> Delete';
                        deleteBtn.setAttribute('onclick', `deleteBlock('${blockId}')`);

                        const insertWrap = document.createElement('div');
                        insertWrap.className = 'insert-block-wrap';
                        insertWrap.setAttribute('contenteditable', 'false');
                        insertWrap.innerHTML = `
                            <button class="insert-block-btn" onclick="openInsertMenu(this, '${blockId}')" title="Insert New Block" contenteditable="false">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        `;

                        // Clone the section
                        const sectionClone = section.cloneNode(true);

                        // Replace original section with wrapped version
                        section.parentNode.replaceChild(wrapper, section);
                        wrapper.appendChild(deleteBtn);
                        wrapper.appendChild(sectionClone);
                        wrapper.appendChild(insertWrap);
                    });

                    return tempDiv.innerHTML;
                }

                // Helper Functions for Document Extraction

                // Group PDF text items by Y-coordinate to detect lines
                function groupItemsByLine(items) {
                    const lines = [];
                    let currentLine = [];
                    let lastY = null;

                    items.forEach(item => {
                        if (!item.transform || typeof item.transform[5] === 'undefined') return;

                        const y = Math.round(item.transform[5]);

                        if (lastY === null || Math.abs(y - lastY) < 5) {
                            currentLine.push(item);
                        } else {
                            if (currentLine.length > 0) lines.push([...currentLine]);
                            currentLine = [item];
                        }
                        lastY = y;
                    });

                    if (currentLine.length > 0) lines.push(currentLine);
                    return lines;
                }

                // Get average font height from line items
                function getAverageHeight(line) {
                    const heights = line.filter(item => item.height && item.height > 0).map(item => item.height);
                    return heights.length > 0 ? heights.reduce((sum, h) => sum + h, 0) / heights.length : 12;
                }

                // Check if text appears to be bold based on font name
                function isFontBold(line) {
                    return line.some(item => {
                        const fontName = item.fontName || '';
                        return fontName.includes('Bold') || fontName.includes('Heavy') || fontName.includes('Black');
                    });
                }

                // Detect if items form a table based on X-positions
                function detectTables(items) {
                    // Simple table detection: look for consistent X-positions across multiple lines
                    const tables = [];
                    // This is a simplified version - full implementation would be more complex
                    return tables;
                }

                // Convert detected table to HTML with inline styles
                function convertTableToHTML(tableData) {
                    let html = '<table style="border-collapse: collapse; width: 100%; margin: 15px 0; border: 1px solid #d1d5db;">\n';

                    tableData.forEach((row, rowIndex) => {
                        const isHeader = rowIndex === 0;
                        html += '  <tr>\n';

                        row.forEach(cell => {
                            const tag = isHeader ? 'th' : 'td';
                            const style = isHeader
                                ? 'padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; border: 1px solid #d1d5db;'
                                : 'padding: 10px; border: 1px solid #d1d5db; color: #374151;';
                            const editable = isHeader ? '' : ' contenteditable="true"';

                            html += `    < ${tag} style = "${style}"${editable}> ${cell}</${tag}>\n`;
                        });

                        html += '  </tr>\n';
                    });

                    html += '</table>\n';
                    return html;
                }

                // Add inline styles to HTML elements
                function addInlineStylesToHTML(html) {
                    // Parse and add inline styles to match template pattern
                    let styled = html;

                    // Style headings
                    styled = styled.replace(/<h1>/gi, '<h1 style="font-size: 28px; font-weight: bold; color: #1f2937; margin: 20px 0 10px 0;" contenteditable="true">');
                    styled = styled.replace(/<h2>/gi, '<h2 style="font-size: 20px; font-weight: bold; color: #1f2937; margin: 18px 0 10px 0;" contenteditable="true">');
                    styled = styled.replace(/<h3>/gi, '<h3 style="font-size: 18px; font-weight: 600; color: #374151; margin: 16px 0 8px 0;" contenteditable="true">');
                    styled = styled.replace(/<h4>/gi, '<h4 style="font-size: 16px; font-weight: 600; color: #4b5563; margin: 14px 0 8px 0;" contenteditable="true">');

                    // Style paragraphs
                    styled = styled.replace(/<p>/gi, '<p style="color: #374151; margin: 10px 0; line-height: 1.6;" contenteditable="true">');

                    // Style lists
                    styled = styled.replace(/<ul>/gi, '<ul style="list-style-type: disc; padding-left: 20px; color: #374151; line-height: 1.6; margin: 12px 0;">');
                    styled = styled.replace(/<ol>/gi, '<ol style="list-style-type: decimal; padding-left: 20px; color: #374151; line-height: 1.6; margin: 12px 0;">');
                    styled = styled.replace(/<li>/gi, '<li style="margin: 6px 0;" contenteditable="true">');

                    // Style tables
                    styled = styled.replace(/<table>/gi, '<table style="border-collapse: collapse; width: 100%; margin: 15px 0; border: 1px solid #d1d5db;">');
                    styled = styled.replace(/<th>/gi, '<th style="padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; border: 1px solid #d1d5db;">');
                    styled = styled.replace(/<td>/gi, '<td style="padding: 10px; border: 1px solid #d1d5db; color: #374151;" contenteditable="true">');

                    // Style strong/em
                    styled = styled.replace(/<strong>/gi, '<strong style="font-weight: bold; color: #1f2937;">');
                    styled = styled.replace(/<em>/gi, '<em style="font-style: italic;">');

                    return styled;
                }

                // Enhanced PDF extraction with formatting
                async function extractPDFWithFormatting(arrayBuffer) {
                    const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
                    let htmlContent = '';

                    for (let pageNum = 1; pageNum <= pdf.numPages; pageNum++) {
                        const page = await pdf.getPage(pageNum);
                        const textContent = await page.getTextContent();

                        // Group items into lines
                        const lines = groupItemsByLine(textContent.items);

                        // Convert lines to HTML with formatting
                        lines.forEach(line => {
                            const text = line.map(item => item.str || '').join(' ').trim();
                            if (!text) return;

                            const avgHeight = getAverageHeight(line);
                            const isBold = isFontBold(line);

                            // Detect heading levels based on font size
                            if (avgHeight > 18) {
                                htmlContent += `<h1 style = "font-size: 28px; font-weight: bold; color: #1f2937; margin: 20px 0 10px 0;" contenteditable = "true" > ${text}</h1 >\n`;
                            } else if (avgHeight > 15) {
                                htmlContent += `<h2 style = "font-size: 20px; font-weight: bold; color: #1f2937; margin: 18px 0 10px 0;" contenteditable = "true" > ${text}</h2 >\n`;
                            } else if (avgHeight > 13) {
                                htmlContent += `<h3 style = "font-size: 18px; font-weight: 600; color: #374151; margin: 16px 0 8px 0;" contenteditable = "true" > ${text}</h3 >\n`;
                            } else if (isBold) {
                                htmlContent += `<p style = "font-weight: bold; color: #1f2937; margin: 10px 0; line-height: 1.6;" contenteditable = "true" > ${text}</p >\n`;
                            } else {
                                htmlContent += `<p style = "color: #374151; margin: 10px 0; line-height: 1.6;" contenteditable = "true" > ${text}</p >\n`;
                            }
                        });

                        // Add page separator
                        if (pageNum < pdf.numPages) {
                            htmlContent += '<hr style="margin: 30px 0; border: none; border-top: 1px solid #e5e7eb;">\n';
                        }
                    }

                    return htmlContent;
                }

                // Text and Field Insertion Functions
                function insertText() {
                    const selection = window.getSelection();
                    if (!selection.rangeCount) return;
                    
                    const range = selection.getRangeAt(0);
                    const p = document.createElement('p');
                    p.className = "text-gray-600 mb-2 text-base";
                    p.textContent = "New text block...";
                    
                    // Check if selection is inside proposalContent
                    if (!document.getElementById('proposalContent').contains(range.commonAncestorContainer)) {
                        document.getElementById('proposalContent').appendChild(p);
                    } else {
                        range.deleteContents();
                        range.insertNode(p);
                        // Move cursor after the new paragraph
                        range.setStartAfter(p);
                        range.setEndAfter(p);
                        selection.removeAllRanges();
                        selection.addRange(range);
                    }
                }

                function insertField(fieldName) {
                    const selection = window.getSelection();
                    const editor = document.getElementById('proposalContent');
                    let range;

                    if (selection.rangeCount > 0) {
                        range = selection.getRangeAt(0);
                        // Check if selection is inside proposalContent
                        if (!editor.contains(range.commonAncestorContainer)) {
                            range = null;
                        }
                    }

                    const span = document.createElement('span');
                    span.className = "bg-indigo-50 text-indigo-600 px-1.5 py-0.5 rounded border border-indigo-100 font-medium text-sm select-none";
                    span.contentEditable = "false"; // Make the placeholder itself non-editable
                    // Use @ to escape Blade curly braces
                    span.textContent = `@1`;
                    span.dataset.field = fieldName;

                    // Add a space after the field for easier typing
                    const space = document.createTextNode("\u00A0");

                    if (range) {
                        range.deleteContents();
                        range.insertNode(span);
                        
                        range.setStartAfter(span);
                        range.setEndAfter(span);
                        range.insertNode(space);
                        
                        // Move cursor after the space
                        range.setStartAfter(space);
                        range.setEndAfter(space);
                        selection.removeAllRanges();
                        selection.addRange(range);
                    } else {
                        // Append to end if no valid selection
                        editor.appendChild(span);
                        editor.appendChild(space);
                        
                        // Set cursor to end
                        range = document.createRange();
                        range.setStartAfter(space);
                        range.setEndAfter(space);
                        selection.removeAllRanges();
                        selection.addRange(range);
                        editor.focus();
                    }
                }

                // Enhanced DOCX extraction with inline styles
                async function extractDOCXWithInlineStyles(arrayBuffer) {
                    const options = {
                        styleMap: [
                            "p[style-name='Heading 1'] => h1:fresh",
                            "p[style-name='Heading 2'] => h2:fresh",
                            "p[style-name='Heading 3'] => h3:fresh",
                            "p[style-name='Heading 4'] => h4:fresh",
                            "p[style-name='Normal'] => p:fresh",
                            "r[style-name='Strong'] => strong",
                            "r[style-name='Emphasis'] => em"
                        ].join("\n"),
                        convertImage: mammoth.images.imgElement(function (image) {
                            return image.read("base64").then(function (imageBuffer) {
                                return {
                                    src: "data:" + image.contentType + ";base64," + imageBuffer,
                                    style: "max-width: 100%; height: auto; margin: 20px 0;"
                                };
                            });
                        })
                    };

                    const result = await mammoth.convertToHtml({ arrayBuffer }, options);

                    // Add inline styles to the generated HTML
                    let styledHTML = addInlineStylesToHTML(result.value);

                    // Log any warnings
                    if (result.messages.length > 0) {
                        console.log("DOCX conversion messages:", result.messages);
                    }

                    return styledHTML;
                }

                // Enhanced Excel extraction with styling
                async function extractExcelWithStyling(arrayBuffer) {
                    const workbook = XLSX.read(arrayBuffer, { type: "array" });
                    const worksheet = workbook.Sheets[workbook.SheetNames[0]];

                    if (!worksheet['!ref']) return '<p style="color: #374151;">Empty spreadsheet</p>';

                    const range = XLSX.utils.decode_range(worksheet['!ref']);
                    let tableHTML = '<table style="border-collapse: collapse; width: 100%; margin: 15px 0; border: 1px solid #d1d5db;">\n';

                    for (let row = range.s.r; row <= range.e.r; row++) {
                        const isHeader = row === range.s.r;
                        tableHTML += '  <tr' + (row % 2 === 1 && !isHeader ? ' style="background-color: #f9fafb;"' : '') + '>\n';

                        for (let col = range.s.c; col <= range.e.c; col++) {
                            const cellAddress = XLSX.utils.encode_cell({ r: row, c: col });
                            const cell = worksheet[cellAddress];
                            const cellValue = cell ? (cell.v || '') : '';

                            const tag = isHeader ? 'th' : 'td';
                            const style = isHeader
                                ? 'padding: 10px; background-color: #f3f4f6; text-align: left; font-size: 12px; font-weight: 600; color: #6b7280; border: 1px solid #d1d5db;'
                                : 'padding: 10px; border: 1px solid #d1d5db; color: #374151;';
                            const editable = isHeader ? '' : ' contenteditable="true"';

                            tableHTML += `    < ${tag} style = "${style}"${editable}> ${cellValue}</${tag}>\n`;
                        }

                        tableHTML += '  </tr>\n';
                    }

                    tableHTML += '</table>\n';
                    return tableHTML;
                }

                // Main extraction function
                async function extractAndCreateProposal(file) {
                    let extractedHTML = "<p>No content found.</p>";

                    try {
                        if (file.type === "application/pdf") {
                            const arrayBuffer = await file.arrayBuffer();
                            extractedHTML = await extractPDFWithFormatting(arrayBuffer);

                        } else if (file.name.endsWith('.docx') || file.name.endsWith('.doc')) {
                            const arrayBuffer = await file.arrayBuffer();
                            extractedHTML = await extractDOCXWithInlineStyles(arrayBuffer);

                        } else if (file.name.match(/\.(xlsx|xls)$/)) {
                            const arrayBuffer = await file.arrayBuffer();
                            extractedHTML = await extractExcelWithStyling(arrayBuffer);
                        }
                    } catch (e) {
                        console.error("Document extraction error:", e);
                        extractedHTML = "<p style='color: #dc2626;'>Error processing file: " + (e.message || "Unknown error") + "</p>";
                    }

                    document.getElementById('proposalCardsView').classList.add('hidden');
                    fullEditorView.classList.remove('hidden');
                    closeModal('uploadModal'); // Use closeModal to restore body scroll

                    // Show formatting toolbar
                    showFormattingToolbar();

                    const today = new Date().toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' });

                    // Wrap extracted content in editable blocks
                    const wrappedContent = wrapContentInEditableBlocks(extractedHTML);
                    proposalContent.innerHTML = `
                                                                                                    <div class="pdf-export-container" >
                                                                                                        <div style="text-align: center; padding: 40px 0;">
                                                                                                            <h1 style="font-size: 36px; font-weight: bold; color: #1f2937; margin-bottom: 20px;">Custom Proposal - ${file.name.split('.').slice(0, -1).join('.')}</h1>
                                                                                                            <p style="font-size: 20px; color: #374151; margin-bottom: 15px;">Prepared for <span id="clientName" class="editable-client-name" style="font-weight: bold; color: #6366f1;">Client Name</span></p>
                                                                                                            <p style="font-size: 18px; color: #6b7280;">Date: <span style="font-weight: bold;">${today}</span></p>
                                                                                                            <div style="margin-top: 40px; text-align: left;">
                                                                                                                ${wrappedContent}
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div >
                                                                                                    `;

                    currentProposal = {
                        template: { name: "Custom Proposal", key: "custom" },
                        client: { name: "Client Name", company: "Company Name" },
                        content: proposalContent.innerHTML,
                        lastSaved: new Date()
                    };

                    document.getElementById('quickEditPanel').classList.remove('translate-x-full');
                    document.getElementById('editClientName').value = "";
                    document.getElementById('editClientCompany').value = "";
                }

                const templatePreset = document.getElementById('templatePreset');
                if (templatePreset) templatePreset.onchange = function () {
                    document.getElementById('customFields').classList.toggle('hidden', this.value !== 'others');
                };

                const addTemplateBtn = document.getElementById('addTemplateBtn');
                if (addTemplateBtn) addTemplateBtn.onclick = () => {
                    openModal('addTemplateModal');
                    if (templatePreset) templatePreset.value = '';
                    const customFields = document.getElementById('customFields');
                    if (customFields) customFields.classList.add('hidden');
                };

                const saveTemplateBtn = document.getElementById('saveTemplate');
                if (saveTemplateBtn) saveTemplateBtn.onclick = () => {
                    if (!templatePreset) return;
                    const preset = templatePreset.value;
                    if (!preset) return alert("Please select a preset");

                    let name, key = preset, icon = "hashtag", color = "indigo", description = "";

                    if (preset === 'others') {
                        name = document.getElementById('customName').value.trim();
                        if (!name) return alert("Template name required!");
                        
                        // Check if template exists
                        const existingTemplateIndex = customTemplates.findIndex(t => t.name.toLowerCase() === name.toLowerCase());
                        
                        if (existingTemplateIndex !== -1) {
                            const existing = customTemplates[existingTemplateIndex];
                            if (existing.deleted) {
                                // Restore soft-deleted template
                                if (confirm(`Template "${name}" was previously deleted. Do you want to restore it?`)) {
                                    existing.deleted = false;
                                    existing.description = document.getElementById('customDesc').value.trim();
                                    existing.icon = document.getElementById('customIcon').value;
                                    existing.color = document.getElementById('customColor').value;
                                    saveTemplates();
                                    renderTemplates();
                                    closeModal('addTemplateModal');
                                    return;
                                } else {
                                    return; // User cancelled restore
                                }
                            } else {
                                return alert("Template already exists!");
                            }
                        }
                        
                        description = document.getElementById('customDesc').value.trim();
                        icon = document.getElementById('customIcon').value;
                        color = document.getElementById('customColor').value;
                        key = "custom_" + Date.now();
                    } else {
                        const presets = {
                            social: { name: "Social Media Marketing Proposal", description: "Complete social media strategy, content calendar, and performance tracking", icon: "hashtag", color: "indigo" },
                            website: { name: "Website Development Proposal", description: "Custom website design, development, and ongoing maintenance", icon: "globe", color: "blue" },
                            ads: { name: "Google Ads Proposal", description: "PPC campaign setup, management, and optimization for maximum ROI", icon: "ad", color: "green" },
                            seo: { name: "SEO Proposal", description: "Search engine optimization strategy to improve organic rankings", icon: "search", color: "purple" }
                        };
                        const p = presets[preset];
                        
                        // Check if preset template exists
                        const existingTemplateIndex = customTemplates.findIndex(t => t.name === p.name);
                        
                        if (existingTemplateIndex !== -1) {
                            const existing = customTemplates[existingTemplateIndex];
                            if (existing.deleted) {
                                // Restore soft-deleted template
                                if (confirm(`Template "${p.name}" was previously deleted. Do you want to restore it?`)) {
                                    existing.deleted = false;
                                    saveTemplates();
                                    renderTemplates();
                                    closeModal('addTemplateModal');
                                    return;
                                } else {
                                    return;
                                }
                            } else {
                                return alert("This template already exists!");
                            }
                        }
                        
                        name = p.name;
                        description = p.description;
                        icon = p.icon;
                        color = p.color;
                    }

                    customTemplates.push({ id: nextId++, name, description, key, icon, color, isDefault: false });
                    saveTemplates();
                    renderTemplates();
                    closeModal('addTemplateModal');
                };

                const openUploadModalBtn = document.getElementById('openUploadModal');
                if (openUploadModalBtn) openUploadModalBtn.onclick = () => openModal('uploadModal');

                const cancelUploadBtn = document.getElementById('cancelUpload');
                if (cancelUploadBtn) cancelUploadBtn.onclick = () => {
                    closeModal('uploadModal');
                    setTimeout(clearFileSelection, 300);
                };

                const backToCardsBtn = document.getElementById('backToCards');
                if (backToCardsBtn) backToCardsBtn.onclick = () => {
                    fullEditorView.classList.add('hidden');
                    const formattingToolbar = document.getElementById('formattingToolbar');
                    if (formattingToolbar) {
                        formattingToolbar.style.display = 'none'; // Ensure hidden
                        formattingToolbar.classList.add('hidden'); // Double safety
                    }
                    document.getElementById('proposalCardsView').classList.remove('hidden');

                    // Also ensure saved proposals are visible if they exist
                    renderSavedProposals();
                };
                const toggleQuickEdit = document.getElementById('toggleQuickEdit');
                if (toggleQuickEdit) toggleQuickEdit.onclick = () => document.getElementById('quickEditPanel').classList.remove('translate-x-full');

                const closeQuickEdit = document.getElementById('closeQuickEdit');
                if (closeQuickEdit) closeQuickEdit.onclick = () => document.getElementById('quickEditPanel').classList.add('translate-x-full');

                const applyQuickEdits = document.getElementById('applyQuickEdits');
                if (applyQuickEdits) applyQuickEdits.onclick = () => {
                    const name = document.getElementById('editClientName').value.trim();
                    const company = document.getElementById('editClientCompany').value.trim();

                    document.querySelectorAll('#clientName').forEach(el => el.textContent = name || "Client Name");
                    document.querySelectorAll('#clientCompany').forEach(el => el.textContent = company || "Company Name");

                    document.getElementById('quickEditPanel').classList.add('translate-x-full');
                };

                // Save Proposal Function
                const saveProposalBtn = document.getElementById('saveProposal');
                if (saveProposalBtn) saveProposalBtn.onclick = () => saveProposalToServer();

                async function saveProposalToServer() {
                    const saveBtn = document.getElementById('saveProposal');
                    const originalText = saveBtn.innerHTML;
                    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Saving...';

                    const content = proposalContent.innerHTML;
                    const title = currentProposal.template ? currentProposal.template.name : 'Custom Proposal';
                    const clientName = document.getElementById('editClientName').value || "Client Name";
                    const companyName = document.getElementById('editClientCompany').value || "Company Name";

                    try {
                        const response = await fetch("1", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                proposal_id: currentProposal.id,
                                content: content,
                                title: title,
                                client_name: clientName,
                                client_company: companyName,
                                template_key: currentProposal.template ? currentProposal.template.key : null,
                                settings: { key: currentProposal.template ? currentProposal.template.key : null }
                            })
                        });

                        const data = await response.json();
                        if (data.success) {
                            currentProposal.id = data.proposal_id;

                            // Update UI list dynamically
                            const updatedProposalItem = {
                                id: currentProposal.id,
                                title: title,
                                content: content,
                                updated_at: new Date().toISOString(),
                                client: {
                                    contact_person: clientName,
                                    company_name: companyName
                                },
                                settings: { key: currentProposal.template ? currentProposal.template.key : null }
                            };

                            const idx = serverProposals.findIndex(p => p.id === currentProposal.id);
                            if (idx !== -1) {
                                serverProposals[idx] = updatedProposalItem;
                            } else {
                                serverProposals.unshift(updatedProposalItem);
                            }
                            renderSavedProposals();
                            // Show toast
                            const saveToast = document.getElementById('saveToast');
                            saveToast.classList.remove('hidden');
                            void saveToast.offsetWidth; // Force reflow
                            saveToast.classList.remove('translate-y-full', 'opacity-0');
                            
                            setTimeout(() => {
                                saveToast.classList.add('translate-y-full', 'opacity-0');
                                setTimeout(() => {
                                    saveToast.classList.add('hidden');
                                }, 500); // Wait for transition to complete
                            }, 3000);
                        }
                    } catch (e) {
                        console.error(e);
                        alert('Failed to save proposal');
                    } finally {
                        saveBtn.innerHTML = originalText;
                    }
                }

                // Improved DOC Export Function
                const exportDOCBtn = document.getElementById('exportDOC');
                if (exportDOCBtn) exportDOCBtn.onclick = () => {
                    // First save the proposal
                    const saveProp = document.getElementById('saveProposal');
                    if (saveProp) saveProp.click();

                    // Get the proposal content
                    const element = document.getElementById('proposalContent').cloneNode(true);

                    // Remove edit icons and other non-printable elements
                    const editIcons = element.querySelectorAll('.edit-icon');
                    editIcons.forEach(icon => icon.remove());

                    // Remove delete buttons
                    const deleteButtons = element.querySelectorAll('.delete-block-btn');
                    deleteButtons.forEach(btn => btn.remove());

                    // Remove insert block wraps
                    const insertWraps = element.querySelectorAll('.insert-block-wrap');
                    insertWraps.forEach(wrap => wrap.remove());

                    // Remove contenteditable attributes
                    const editableElements = element.querySelectorAll('[contenteditable="true"]');
                    editableElements.forEach(el => {
                        el.removeAttribute('contenteditable');
                    });

                    // Get properly formatted HTML content
                    const htmlContent = element.innerHTML;

                    // Create proper Word document with Microsoft Word HTML format
                    const wordDocument = `
                            <html xmlns:o='urn:schemas-microsoft-com:office:office' 
                                  xmlns:w='urn:schemas-microsoft-com:office:word' 
                                  xmlns='http://www.w3.org/TR/REC-html40'>
                            <head>
                                <meta charset='utf-8'>
                                <title>Proposal Document</title>
                                <!--[if gte mso 9]>
                                <xml>
                                    <w:WordDocument>
                                        <w:View>Print</w:View>
                                        <w:Zoom>100</w:Zoom>
                                        <w:DoNotOptimizeForBrowser/>
                                    </w:WordDocument>
                                </xml>
                                <![endif]-->
                                <style>
                                    @page {
                                        size: A4;
                                        margin: 1in;
                                    }
                                    body {
                                        font-family: 'Calibri', 'Arial', sans-serif;
                                        font-size: 11pt;
                                        line-height: 1.5;
                                        color: #000000;
                                    }
                                    h1 {
                                        font-size: 24pt;
                                        font-weight: bold;
                                        margin: 12pt 0;
                                    }
                                    h2 {
                                        font-size: 18pt;
                                        font-weight: bold;
                                        margin: 10pt 0;
                                    }
                                    h3 {
                                        font-size: 14pt;
                                        font-weight: bold;
                                        margin: 8pt 0;
                                    }
                                    p {
                                        margin: 6pt 0;
                                    }
                                    table {
                                        border-collapse: collapse;
                                        width: 100%;
                                        margin: 10pt 0;
                                    }
                                    th, td {
                                        border: 1pt solid #000000;
                                        padding: 6pt;
                                    }
                                    th {
                                        background-color: #f3f4f6;
                                        font-weight: bold;
                                    }
                                    ul, ol {
                                        margin: 6pt 0;
                                        padding-left: 20pt;
                                    }
                                    li {
                                        margin: 3pt 0;
                                    }
                                </style>
                            </head>
                            <body>
                                ${htmlContent}
                            </body>
                            </html>
                        `;

                    // Create a Blob with proper Word document format
                    const blob = new Blob(['\ufeff', wordDocument], {
                        type: 'application/msword'
                    });

                    // Create a download link
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = 'proposal.doc';

                    // Trigger download
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);

                    // Clean up the URL object
                    URL.revokeObjectURL(link.href);
                };


                // Fixed PDF Export Function
                const exportPDFBtn = document.getElementById('exportPDF');
                if (exportPDFBtn) exportPDFBtn.onclick = () => {
                    // First save the proposal
                    const saveProp = document.getElementById('saveProposal');
                    if (saveProp) saveProp.click();

                    // Create a clone of the proposal content to avoid affecting the original
                    const contentElement = document.getElementById('proposalContent');
                    if (!contentElement) return;
                    
                    const element = contentElement.cloneNode(true);

                    // Remove edit icons and other non-printable elements
                    const editIcons = element.querySelectorAll('.edit-icon');
                    editIcons.forEach(icon => icon.remove());

                    // Remove delete buttons
                    const deleteButtons = element.querySelectorAll('.delete-block-btn');
                    deleteButtons.forEach(btn => btn.remove());

                    // Remove insert block wraps
                    const insertWraps = element.querySelectorAll('.insert-block-wrap');
                    insertWraps.forEach(wrap => wrap.remove());

                    // Remove contenteditable attributes for PDF
                    const editableElements = element.querySelectorAll('[contenteditable="true"]');
                    editableElements.forEach(el => {
                        el.removeAttribute('contenteditable');
                    });

                    // Configure PDF options with proper margins and scaling
                    const opt = {
                        margin: [0.5, 0.5, 0.5, 0.5], // Top, Right, Bottom, Left margins
                        filename: 'proposal.pdf',
                        image: { type: 'jpeg', quality: 0.98 },
                        html2canvas: {
                            scale: 2,
                            useCORS: true,
                            logging: false,
                            letterRendering: true,
                            width: element.scrollWidth,
                            height: element.scrollHeight
                        },
                        jsPDF: {
                            unit: 'in',
                            format: 'a4',
                            orientation: 'portrait'
                        },
                        pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
                    };

                    // Generate and save PDF
                    html2pdf().set(opt).from(element).save();
                };

                // Initialize the app
                (async () => {
                    await loadTemplates(); // loadTemplates now calls renderTemplates internally
                })();

                // Initialize Saved Proposals from Server
                const serverProposals = [];
                renderSavedProposals();

                function renderSavedProposals() {
                    const list = document.getElementById('sidebarProposalsList');

                    if (serverProposals.length === 0) {
                        list.innerHTML = '<div class="text-center py-8 text-gray-400 text-xs">No recent proposals.</div>';
                        return;
                    }

                    list.innerHTML = '';

                    // Group proposals by client (using client_id or company_name)
                    const grouped = {};
                    serverProposals.forEach(p => {
                        const key = (p.client && p.client.id) ? p.client.id : (p.client ? p.client.company_name : 'Unknown');
                        if (!grouped[key]) {
                            grouped[key] = {
                                client: p.client,
                                companyName: p.client ? p.client.company_name : 'Unknown Company',
                                contactPerson: p.client ? p.client.contact_person : 'Unknown Client',
                                proposals: []
                            };
                        }
                        grouped[key].proposals.push(p);
                    });

                    // Render groups in sidebar
                    Object.values(grouped).forEach(group => {
                        // Sort proposals to find the latest
                        group.proposals.sort((a, b) => new Date(b.updated_at) - new Date(a.updated_at));
                        const latestDate = new Date(group.proposals[0].updated_at).toLocaleDateString([], { month: 'short', day: 'numeric' });
                        const proposalCount = group.proposals.length;
                        
                        const item = document.createElement('div');
                        item.className = "p-3 border-b border-gray-100 hover:bg-indigo-50/50 cursor-pointer transition-colors group relative";
                        item.innerHTML = `
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-sm font-bold text-gray-800 truncate pr-4 group-hover:text-indigo-700">${group.companyName}</h3>
                                <span class="text-[10px] text-gray-400 whitespace-nowrap">${latestDate}</span>
                            </div>
                            <div class="flex justify-between items-end">
                                <p class="text-xs text-gray-500 truncate">${proposalCount} proposal(s) sent</p>
                            </div>
                        `;

                        // Add click event to open the Chat View
                        item.onclick = () => {
                            openChatView(group);
                        };

                        list.appendChild(item);
                    });
                }

                function openChatView(group) {
                    // Hide other views, show chat view
                    document.getElementById('proposalCardsView').classList.add('hidden');
                    document.getElementById('fullEditorView').classList.add('hidden');
                    document.getElementById('chatView').classList.remove('hidden');
                    
                    // Update header
                    document.getElementById('chatHeaderCompany').textContent = group.companyName;
                    document.getElementById('chatHeaderContact').textContent = group.contactPerson;

                    // Populate messages
                    const messagesArea = document.getElementById('chatMessagesArea');
                    messagesArea.innerHTML = '';
                    
                    // Sort oldest to newest for chat
                    const chatProposals = [...group.proposals].sort((a, b) => new Date(a.updated_at) - new Date(b.updated_at));

                    chatProposals.forEach(p => {
                        const time = new Date(p.updated_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        const date = new Date(p.updated_at).toLocaleDateString([], { month: 'short', day: 'numeric' });
                        
                        const msgDiv = document.createElement('div');
                        msgDiv.className = "flex justify-end mb-4"; // WhatsApp sent message style
                        msgDiv.innerHTML = `
                            <div class="max-w-[80%] bg-indigo-50 border border-indigo-100 rounded-2xl rounded-tr-none p-3 shadow-sm relative group">
                                <h4 class="font-bold text-sm text-gray-800 mb-1">${p.title}</h4>
                                <p class="text-xs text-gray-600 mb-2">Proposal Document</p>
                                <div class="flex items-center justify-between gap-4">
                                    <button class="open-saved-msg text-xs bg-indigo-600 text-white px-3 py-1.5 rounded-lg hover:bg-indigo-700 transition-colors shadow-sm font-semibold">
                                        <i class="fas fa-edit mr-1"></i> Open Editor
                                    </button>
                                    <span class="text-[10px] text-gray-400">${date} at ${time}</span>
                                </div>
                                <button class="delete-proposal absolute -top-2 -left-2 bg-white text-gray-400 hover:text-red-500 rounded-full w-6 h-6 shadow flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity" data-id="${p.id}" title="Delete">
                                    <i class="fas fa-trash text-[10px]"></i>
                                </button>
                            </div>
                        `;

                        // Add open logic
                        msgDiv.querySelector('.open-saved-msg').onclick = () => {
                            openSavedProposalInEditor(p, group);
                        };

                        messagesArea.appendChild(msgDiv);
                    });

                    // Scroll to bottom
                    messagesArea.scrollTop = messagesArea.scrollHeight;

                    // Setup Create New button
                    document.getElementById('chatCreateNewBtn').onclick = () => {
                        // Go back to proposal cards view but maybe auto-select client?
                        // For now, let's just go back to cards view and open client search.
                        document.getElementById('chatView').classList.add('hidden');
                        document.getElementById('proposalCardsView').classList.remove('hidden');
                        // Optional: Highlight to the user they can pick a template
                    };
                }

                function openSavedProposalInEditor(p, group) {
                    // Hide chat, show editor
                    document.getElementById('chatView').classList.add('hidden');
                    document.getElementById('fullEditorView').classList.remove('hidden');
                    showFormattingToolbar();

                    const headerInfo = document.getElementById('headerClientInfo');
                    let infoText = `${group.companyName} - ${group.contactPerson}`;
                    if(p.client && p.client.phone) infoText += ` | 📱 ${p.client.phone}`;
                    headerInfo.textContent = infoText;
                    headerInfo.classList.remove('hidden');

                    if (!p.content.includes('editable-block')) {
                        p.content = wrapContentInEditableBlocks(p.content);
                    }
                    
                    proposalContent.innerHTML = p.content;
                    currentProposal = p;

                    // Ensure WhatsApp variables are populated
                    document.getElementById('editClientName').value = group.contactPerson;
                    document.getElementById('editClientCompany').value = group.companyName;
                }

                // Handle back button from Chat
                document.getElementById('closeChatBtn')?.addEventListener('click', () => {
                    document.getElementById('chatView').classList.add('hidden');
                    document.getElementById('proposalCardsView').classList.remove('hidden');
                });

                // Override deleteSavedProposal to refresh view properly

                function loadSavedProposal(proposal) {
                    proposalContent.innerHTML = proposal.content;
                    currentProposal = {
                        id: proposal.id,
                        template: { key: proposal.settings?.key || 'custom', name: proposal.title },
                        client: {
                            name: proposal.client ? proposal.client.contact_person : '',
                            company: proposal.client ? proposal.client.company_name : ''
                        },
                        content: proposal.content,
                        lastSaved: new Date(proposal.updated_at)
                    };

                    // Update toolbar
                    document.getElementById('editClientName').value = currentProposal.client.name;
                    document.getElementById('editClientCompany').value = currentProposal.client.company;

                    // Show editor
                    document.getElementById('proposalCardsView').classList.add('hidden');
                    document.getElementById('savedProposalsSection').classList.add('hidden');
                    fullEditorView.classList.remove('hidden');
                    
                    // Show formatting toolbar
                    showFormattingToolbar();
                }

                function deleteSavedProposal(e, id) {
                    e.stopPropagation();
                    if (!confirm('Are you sure you want to delete this proposal?')) return;

                    fetch(`/proposals/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        }
                    }).then(() => {
                        window.location.reload();
                    });
                }
                function openWhatsAppModal() {
                    if (!document.getElementById('editClientName').value) {
                        alert("Please provide a client name first.");
                        return;
                    }
                    const clientName = document.getElementById('editClientName').value;
                    const clientCompany = document.getElementById('editClientCompany').value || "Company";
                    
                    // Try to find the client's phone number
                    let phone = "";
                    const client = crmClients.find(c => c.company_name === clientCompany || c.contact_person === clientName);
                    if (client && client.phone) {
                        phone = client.phone;
                    }

                    document.getElementById('waPhone').value = phone;
                    document.getElementById('waMessage').value = `Hi ${clientName},\n\nHere is our proposal for your review. Let us know if you have any questions.\n\nThanks,\nSocial Cults`;
                    
                    document.getElementById('whatsappModal').classList.remove('hidden');
                }

                function closeWhatsAppModal() {
                    document.getElementById('whatsappModal').classList.add('hidden');
                }

                async function sendViaWhatsApp() {
                    const phone = document.getElementById('waPhone').value.replace(/[^0-9]/g, '');
                    const message = document.getElementById('waMessage').value;
                    const clientName = document.getElementById('editClientName').value;

                    if (!phone) {
                        alert('Please enter a valid phone number.');
                        return;
                    }

                    const btn = document.getElementById('waSendBtn');
                    const originalText = btn.innerHTML;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Generating Link...';
                    btn.disabled = true;

                    try {
                        // Get HTML element for PDF
                        const element = document.getElementById('documentContent');
                        
                        // Use html2pdf to generate a Blob instead of downloading
                        const opt = {
                            margin: 0,
                            filename: 'proposal.pdf',
                            image: { type: 'jpeg', quality: 0.98 },
                            html2canvas: { scale: 2, useCORS: true, letterRendering: true },
                            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
                        };

                        const pdfBlob = await html2pdf().set(opt).from(element).output('blob');

                        // Create form data to upload
                        const formData = new FormData();
                        formData.append('pdf', pdfBlob, 'proposal.pdf');
                        formData.append('client_name', clientName);

                        // Upload to server
                        const response = await fetch('/proposals/upload-pdf', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: formData
                        });

                        const result = await response.json();

                        if (result.success) {
                            // Link generated successfully
                            const publicLink = result.url;
                            const finalMessage = encodeURIComponent(`${message}\n\nView Proposal: ${publicLink}`);
                            const waUrl = `https://wa.me/${phone}?text=${finalMessage}`;
                            
                            // Open WhatsApp Web
                            window.open(waUrl, '_blank');
                            closeWhatsAppModal();
                        } else {
                            alert('Failed to generate PDF link.');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('An error occurred while preparing the WhatsApp message.');
                    } finally {
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                }

                // Client Search Modal Logic
                let selectedTemplateForModal = null;

                function openClientSearchModal(template) {
                    selectedTemplateForModal = template;
                    document.getElementById('clientSearchModal').classList.remove('hidden');
                    populateClientSearchList(crmClients);
                    // Focus the search input automatically
                    setTimeout(() => document.getElementById('clientSearchInput').focus(), 100);
                }

                function closeClientSearchModal() {
                    document.getElementById('clientSearchModal').classList.add('hidden');
                    selectedTemplateForModal = null;
                }

                function populateClientSearchList(clients) {
                    const list = document.getElementById('clientSearchList');
                    list.innerHTML = '';

                    if (clients.length === 0) {
                        list.innerHTML = '<div class="text-center py-4 text-gray-500 text-sm">No clients found. Click "Create New" to start fresh.</div>';
                        return;
                    }

                    clients.forEach(client => {
                        const div = document.createElement('div');
                        div.className = 'p-3 hover:bg-indigo-50 border-b border-gray-100 cursor-pointer flex justify-between items-center transition-colors';
                        div.innerHTML = `
                            <div>
                                <div class="font-semibold text-gray-800">${client.company_name || 'N/A'}</div>
                                <div class="text-xs text-gray-500">${client.contact_person || 'N/A'} • ${client.phone || 'No phone'}</div>
                            </div>
                            <button class="px-3 py-1 bg-indigo-100 text-indigo-700 text-xs rounded-full font-bold hover:bg-indigo-200">Select</button>
                        `;
                        div.onclick = () => {
                            closeClientSearchModal();
                            openFullEditor(selectedTemplateForModal, { 
                                name: client.contact_person || 'Client Name', 
                                company: client.company_name || 'Company Name',
                                phone: client.phone || ''
                            });
                        };
                        list.appendChild(div);
                    });
                }

                function handleClientSearch(term) {
                    term = term.toLowerCase();
                    const filtered = crmClients.filter(c => 
                        (c.company_name && c.company_name.toLowerCase().includes(term)) || 
                        (c.contact_person && c.contact_person.toLowerCase().includes(term)) ||
                        (c.phone && c.phone.includes(term))
                    );
                    populateClientSearchList(filtered);
                }

                function continueWithNewClient() {
                    closeClientSearchModal();
                    const name = prompt("Enter Client Name:", "New Client");
                    if (name === null) return;
                    const company = prompt("Enter Company Name:", "New Company");
                    if (company === null) return;
                    openFullEditor(selectedTemplateForModal, { name: name, company: company });
                }
            