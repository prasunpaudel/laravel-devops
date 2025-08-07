# SonarCloud Integration Setup

This document explains how to set up SonarCloud integration for code quality analysis and security scanning in your Laravel project.

## What's Added

### 1. Code Quality Tools
- **PHP CodeSniffer**: Linting tool that checks code against PSR-12 standards
- **PHPStan**: Static analysis tool for finding bugs and type errors
- **Security Checker**: Scans composer.lock for known security vulnerabilities

### 2. SonarCloud Integration
- **Code Quality Analysis**: Detects bugs, vulnerabilities, and code smells
- **Security Scanning**: Identifies security hotspots and vulnerabilities
- **Coverage Reports**: Integrates test coverage data
- **Maintainability**: Calculates technical debt and maintainability ratings

### 3. Configuration Files Added
- `sonar-project.properties`: SonarCloud project configuration
- `phpcs.xml`: PHP CodeSniffer rules and exclusions
- `phpstan.neon`: PHPStan configuration for static analysis

## Setup Instructions

### Step 1: SonarCloud Account Setup
1. Go to [SonarCloud.io](https://sonarcloud.io)
2. Sign in with your GitHub account
3. Import your repository (`prasunpaudel/laravel-devops`)
4. Get your project key and organization key

### Step 2: Update sonar-project.properties
Update the following values in `sonar-project.properties`:
```properties
sonar.projectKey=your-github-username_your-repo-name
sonar.organization=your-sonarcloud-organization
```

### Step 3: Add GitHub Secrets
Add these secrets to your GitHub repository:

1. Go to your repository on GitHub
2. Settings → Secrets and variables → Actions
3. Add these repository secrets:
   - `SONAR_TOKEN`: Get this from SonarCloud project settings
   - `GOOGLE_CHAT_WEBHOOK`: Your Google Chat webhook URL (already added)

### Step 4: SonarCloud Token
1. In SonarCloud, go to your project
2. Project Settings → Analysis Method → GitHub Actions
3. Copy the SONAR_TOKEN value
4. Add it as a GitHub repository secret

## Pipeline Stages

Your CI/CD pipeline now includes these stages:

1. **Setup** (PHP, Composer, Environment)
2. **Dependencies** (Install packages)
3. **Database** (Migrations)
4. **Code Quality**
   - PHP CodeSniffer (PSR-12 compliance)
   - PHPStan (Static analysis)
   - Security audit (Vulnerability scanning)
5. **Testing** (Unit/Feature tests with coverage)
6. **SonarCloud** (Quality gate analysis)
7. **Notifications** (Success/Failure alerts)

## Reports Generated

The pipeline generates several reports:
- `phpcs-report.xml`: Code style violations
- `phpstan-report.xml`: Static analysis issues
- `security-report.json`: Security vulnerabilities
- `coverage.xml`: Test coverage data

## Quality Gates

SonarCloud will fail the build if:
- Security vulnerabilities are found
- Code coverage is below threshold
- Code quality rating drops below standards
- Duplicated code exceeds limits

## Local Development

You can run these tools locally:

```bash
# Install tools
composer require --dev squizlabs/php_codesniffer phpstan/phpstan sensiolabs/security-checker

# Run linting
./vendor/bin/phpcs

# Run static analysis
./vendor/bin/phpstan analyse

# Run security check
./vendor/bin/security-checker security:check composer.lock

# Run tests with coverage
php artisan test --coverage
```

## Benefits

- 🔒 **Security**: Early detection of vulnerabilities
- 🧹 **Code Quality**: Consistent coding standards
- 📊 **Metrics**: Track technical debt and maintainability
- 🐛 **Bug Prevention**: Static analysis catches issues early
- 📈 **Coverage**: Monitor test coverage trends
- 👥 **Team Collaboration**: Shared quality standards

## Troubleshooting

### Common Issues:
1. **SONAR_TOKEN not set**: Add the token to GitHub secrets
2. **Project key mismatch**: Update sonar-project.properties
3. **Quality gate failure**: Check SonarCloud dashboard for details
4. **Coverage issues**: Ensure tests run with --coverage-clover flag

### Support:
- SonarCloud Documentation: https://docs.sonarcloud.io/
- Laravel Testing: https://laravel.com/docs/testing
