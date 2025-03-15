---
description: MASTER RULES - Comprehensive collection of all Cursor rules and their requirements
globs: **/*
alwaysApply: true
version: 1.0.0
---

# Cursor Master Rules

## Core Format Rules

### Your Response
- Your response must always include "🐸" at the beginning to indicate that you are following the rules

### Rule Structure
- Every rule must have a clear description and purpose
- Rules must specify when they apply using ACTION TRIGGER OUTCOME format
- Include proper version tracking using semantic versioning
- Use appropriate glob patterns to specify affected files

### Required Fields
- description: Clear ACTION TRIGGER OUTCOME format
- globs: Appropriate file/folder patterns
- version: Semantic versioning (MAJOR.MINOR.PATCH)
- Additional metadata as needed (tags, priority, etc.)

## Code Modification Rules

### Safe Modifications
1. Always read and understand complete context before modifications
2. Stay within explicitly requested scope
3. Only implement specifically requested changes
4. Preserve existing code and functionality
5. Document all changes clearly

### UI Modifications
1. Target only specific requested sections
2. Preserve parent container structures
3. Maintain existing layout patterns
4. Keep responsive behavior intact
5. Follow Tailwind CSS standards:
   - Use utility classes instead of custom CSS
   - Follow responsive design patterns
   - Use project color palette
   - Maintain consistent spacing

### Data Preservation
1. Identify and document all data display elements before changes
2. Preserve all template variables (e.g., {{ $variable }})
3. Maintain all dynamic content bindings
4. Keep all loops and conditionals intact
5. Preserve form inputs and values

### Relationship Access
1. Never modify relationship access patterns without explicit instruction
2. Preserve all model relationship chains
3. Maintain existing query patterns
4. Keep relationship documentation updated

## Error Handling

### Blade Templates
1. Use proper error handling directives:
```blade
@try
    {{-- Operation --}}
@catch(\Exception $e)
    {{-- Error handling --}}
@endtry
```

2. Always check for validation errors:
```blade
@error('field')
    <div class="invalid-feedback">{{ $message }}</div>
@enderror
```

3. Implement proper null checks:
```blade
{{ $variable ?? 'Default' }}
@isset($variable)
    {{-- Content --}}
@endisset
```

## Route Management

### Department Role Routes
1. Add new department routes to CheckUserRole middleware
2. Follow consistent naming patterns
3. Implement proper access controls
4. Maintain route documentation

### Route Organization
1. Group routes by middleware
2. Group routes by controller
3. Use consistent naming conventions
4. Maintain proper documentation

## Documentation Standards

### Markdown Guidelines
1. Use proper heading hierarchy
2. Include appropriate metadata
3. Use code blocks with language specification
4. Implement proper linking
5. Include diagrams where helpful

### Project Documentation
1. PRD Requirements:
   - Clear project description
   - Defined goals and objectives
   - Detailed feature requirements
   - Epic and story structure
   - Future enhancements

2. Architecture Documentation:
   - Technical summary
   - Technology stack details
   - System diagrams
   - Data models
   - Project structure

3. Story Documentation:
   - Clear user story format
   - Detailed tasks and subtasks
   - Progress tracking
   - Implementation notes
   - Test requirements

## Critical Requirements

<critical>
- ALWAYS read and understand context before changes
- NEVER modify code beyond requested scope
- PRESERVE all data display elements
- MAINTAIN proper error handling
- FOLLOW documentation standards
- TEST all changes thoroughly
</critical>

## Implementation Process

1. Before Changes:
   - Review relevant rules
   - Understand full context
   - Identify affected components
   - Document current state

2. During Changes:
   - Follow safe modification practices
   - Preserve existing functionality
   - Maintain error handling
   - Document modifications

3. After Changes:
   - Verify all requirements met
   - Test functionality
   - Update documentation
   - Review for rule compliance

