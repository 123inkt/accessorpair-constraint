# Upgrading Notes (1.x to 2.0)
### AccessorPairAsserter::assertAccessorPairs
Second paramater ```$testPropertyDefaults = false``` is now replaced with ```ConstraintConfig = null```.   
The default values have the same effect as before.

To upgrade:
- If the value ```true``` was passed before, a ConstraintConfig instance with ```$propertyDefaultCheck=true``` should be passed instead
- If the value ```false``` was passed in order to set the ```$message``` parameter, ```null``` should be passed instead for the default config

### AccessorPairConstraint::__construct
The parameter ```$testPropertyDefaults``` is replaced with ```ConstraintConfig```

To upgrade:
- If the value ```true``` was passed before, a ConstraintConfig instance with ```$assertPropertyDefaults=true``` should be passed instead
  - i.e. ```(new ConstraintConfig())->setAssertPropertyDefaults(true)```
- If the value ```false``` was passed before, ```null``` should be passed instead to get the default ConstraintConfig
