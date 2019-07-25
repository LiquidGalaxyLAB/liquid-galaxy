The two programs in this directory show how to read and write input_event
structs used by the /dev/input/event* interface to multi-axis devices like
the 3dconnexion SpaceNavigator.

## Requirements

```bash
sudo apt install libc6-dev-i386
```

## Compile with:

```bash
gcc -m32 -o read-event read-event.c
gcc -m32 -o write-event write-event.c
```

## Use

### To read from the virtual spacenavigator:

```bash
./read-event /dev/input/spacenavigator
```

### To write to the virtual spacenavigator:

```bash
./write-event /dev/input/spacenavigator 0 100
```
