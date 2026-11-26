productos = []

def menu():
    print("                 ")
    print("\n***MENU***")
    print("1.  Agregar al inicio")
    print("2.  Agregar al final")
    print("3.  Agregar en posición")
    print("4.  Agregar mas de un elemento")
    print("5.  Eliminar ultimo")
    print("6.  Eliminar primer elemento")
    print("7.  Eliminar por nombre")
    print("8.  Eliminar por indice")
    print("9.  Consultar primer elemento")
    print("10. Consultar ultimo elemento")
    print("11. Consultar elemento en posicion x")
    print("12. Consultar toda la lista")
    print("13. Ordenar la lista")
    print("14. Salir")
    print("                 ")


while True:
    menu()
    opcion = input("Elige una opción: ")

    if opcion == "1":
        producto = input("Producto: ")
        productos.insert(0, producto)

    elif opcion == "2":
        producto = input("Producto: ")
        productos.append(producto)

    elif opcion == "3":
        producto = input("Producto: ")
        posicion = int(input("Posición (0 a {}): ".format(len(productos))))
        productos.insert(posicion, producto)

    elif opcion == "4":
        lista_productos = input("Productos separados por coma: ").split(",")
        for producto in lista_productos:
            productos.append(producto.strip())

    elif opcion == "5":
        if productos:
            print(f"Eliminado: {productos.pop()}")
        else:
            print("Lista vacía")

    elif opcion == "6":
        if productos:
            print(f"Eliminado: {productos.pop(0)}")
        else:
            print("Lista vacía")

    elif opcion == "7":
        nombre = input("Nombre a eliminar: ")
        if nombre in productos:
            productos.remove(nombre)
        else:
            print("No existe")

    elif opcion == "8":
        posicion = int(input("Indice a eliminar: "))
        if 0 <= posicion < len(productos):
            productos.pop(posicion)
        else:
            print("Indice fuera de rango")

    elif opcion == "9":
        print(f"Primero: {productos[0]}" if productos else "Lista vacía")

    elif opcion == "10":
        print(f"Ultimo: {productos[-1]}" if productos else "Lista vacía")

    elif opcion == "11":
        posicion = int(input("Posición: "))
        if 0 <= posicion < len(productos):
            print(f"En {posicion}: {productos[posicion]}")
        else:
            print("Indice fuera de rango")

    elif opcion == "12":
        print(productos if productos else "Lista vacía")

    elif opcion == "13":
        productos.sort()
        print("Lista ordenada:", productos)

    elif opcion == "14":
        print("Perfecto")
        break

    else:
        print("Opción no válida")