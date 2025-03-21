# NubeFlash Frontend Documentation

## Hero Section Enhancement (May 2024)

The homepage hero section has been significantly improved to create a more visually appealing and responsive design.

### Key Enhancements

#### Flying Character Image
- **Centered Alignment**: The flying character is now centered to create a stronger visual focus and align vertically with the "About Us" section below
- **Responsive Sizing**: 
  - Desktop: max-width: 438px
  - Large tablets: max-width: 420px
  - Small tablets: max-width: 400px
  - Mobile: max-width: 350px
- **Hover Animation**: Added a subtle upward hover animation using `transform: translateY(-5px)` with a smooth transition

#### "Tus Envíos Vuelan" Text Image
- **Fine-tuned Positioning**: Carefully positioned to complement the flying character
  - Current position: top: -83px, right: -70px
  - Responsive adjustments for all screen sizes
- **Size Optimization**:
  - Desktop: max-width: 313px
  - Large tablets: max-width: 288px
  - Small tablets: max-width: 275px
  - Mobile: max-width: 250px

#### CSS Structure
```css
/* Enhanced Hero Section */
.hero-image-container {
    position: relative;
    display: flex;
    justify-content: center;
    width: 100%;
    max-width: 500px;
    margin: 0 auto;
    margin-top: 5%;
}

.hero-image {
    max-width: 438px;
    height: auto;
    transition: transform 0.3s ease;
}

.flying-text {
    position: absolute;
    top: -83px;
    right: -70px;
    max-width: 313px;
    z-index: 2;
}

.hero-image:hover {
    transform: translateY(-5px);
}
```

#### Responsive Breakpoints
Comprehensive media queries ensure proper display across all device sizes:
- Mobile (max-width: 767px)
- Small tablets (768px - 991px)
- Large tablets (992px - 1199px)
- Desktop (min-width: 1200px)

### HTML Structure
The hero section uses a balanced column layout with responsive classes:
```html
<div class="row align-items-center">
    <div class="col-md-6"> <!-- Text content --> </div>
    <div class="col-md-6"> <!-- Flying character image --> </div>
</div>
```

### Future Enhancement Suggestions
- Consider adding more subtle animations to enhance engagement
- Explore dynamic loading effects for the hero elements
- Test additional color variations for the flying text for better contrast 