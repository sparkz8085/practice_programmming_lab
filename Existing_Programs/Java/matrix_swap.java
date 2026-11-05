import java.util.*;
public class matrix_swap
{
    public static void main(String args[])
    {
        int i, j, temp;
        Scanner sc = new Scanner(System.in);
        System.out.println("Enter the size of the array");
        int n = sc.nextInt();
        int arr[] = new int[n];
        System.out.println("Enter the elements of the array");
        for(i = 0; i < n; i++)
        {
            arr[i] = sc.nextInt();  
        }
        System.out.println("The array before swapping is:");
        for(i = 0; i < n; i++)
        {
            System.out.print(arr[i] + " ");
        }
        System.out.println();
        System.out.println("Enter the positions of the elements to be swapped");
        i = sc.nextInt();
        j = sc.nextInt();
        temp = arr[i];
        arr[i] = arr[j];
        arr[j] = temp;
        System.out.println("The array after swapping is:");
        for(i = 0; i < n; i++)
        {
            System.out.print(arr[i] + " ");
        }
    }
}
