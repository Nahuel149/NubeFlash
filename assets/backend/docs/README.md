# NubeFlash Backend Documentation

## CSS Organization and Asset Management (May 2024)

Recent improvements to the codebase have focused on better organization of CSS styles and asset management to improve maintainability and performance.

### CSS Optimization

#### File Structure
The project now follows a more organized CSS structure:

- **Main CSS Files**:
  - `assets/frontend/extras/extra.css`: Contains project-specific styles
  - `assets/frontend/css/enhanced-style.css`: Enhanced base styles

#### Duplicate Style Removal
- Consolidated duplicate styles in the hero section (#section_home)
- Streamlined media queries for consistent breakpoints
- Improved specificity to reduce CSS conflicts

#### CSS Code Standards
- Used consistent indentation and formatting
- Grouped related properties
- Added clear comments for major sections
- Maintained logical order of media queries (smallest to largest)

### Asset Management

#### Image Optimization
- Reorganized image assets for better classification
- Improved naming conventions for clarity (e.g., tus-envios-vuelan.png)
- Removed unused/deprecated image files

#### Font Management
- Simplified font directory structure
- Consolidated font files to reduce unnecessary duplicates
- Created the montserrat.css file for centralized font definitions

### Responsive Design Implementation

The CSS now implements a consistent approach to responsive design:

```css
/* Base styles (mobile-first) */
.element {
    /* Default styles */
}

/* Tablets */
@media (min-width: 768px) and (max-width: 991px) {
    .element {
        /* Tablet-specific styles */
    }
}

/* Small desktops */
@media (min-width: 992px) and (max-width: 1199px) {
    .element {
        /* Small desktop styles */
    }
}

/* Large desktops */
@media (min-width: 1200px) {
    .element {
        /* Large desktop styles */
    }
}
```

### Best Practices

1. **CSS Organization**:
   - Use specific class names to avoid conflicts
   - Group related styles together
   - Comment major sections
   - Maintain consistent formatting

2. **Asset Management**:
   - Use descriptive filenames
   - Organize assets by type and purpose
   - Remove unused files to reduce codebase size
   - Document custom assets in appropriate README files

3. **Responsive Design**:
   - Follow mobile-first approach
   - Use standard breakpoints
   - Test thoroughly on multiple devices
   - Consider touch interfaces for interactive elements 