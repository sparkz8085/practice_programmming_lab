import java.util.*;
public class sort_2darray
{
    public static void main(String args[])
    {
        Scanner sc= new Scanner(System.in);
        System.out.println("Enter Size of Array:");
        int size= sc.nextInt();
        int arr[][]=new int[size][size];
        int sort[]=new int[size*size];
        int k=0;
        for(int i=0; i<size; i++)
        {
            for(int j=0; j<size; j++)
            {
                System.out.println("Enter Value : ");
                arr[i][j]=sc.nextInt();
                sort[k++]=arr[i][j];
            }
        }
        System.out.println("Unsorted Array : ");
        for(int i=0; i<size; i++)
        {
            for(int j=0; j<size; j++)
            {
                System.out.print(arr[i][j]+"\t");
            }
            System.out.println();
        }
        for(int i=0; i<size*size; i++)
        {
            for(int j=0; j<(size*size)-i-1; j++)
            {
                if(sort[j]>sort[j+1])
                {
                    int temp=sort[j];
                    sort[j]=sort[j+1];
                    sort[j+1]=temp;
                }
            }
        }
        k=0;
        System.out.println("\nSorted Array : ");
        for(int i=0; i<size; i++)
        {
            for(int j=0; j<size; j++)
            {
                arr[i][j]=sort[k++];
                System.out.print(arr[i][j]+"\t");        
            }
            System.out.println();
        }
    }
}
